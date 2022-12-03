<?php

namespace App\Http\Livewire\Finance\PaymentTracker;

use Livewire\Component;
use App\Models\Reservation;
use App\Models\GuestAccommodationPayment;
use GuzzleHttp\Client;

class MultiStepForm extends Component
{
    public $currentStep=1;
    public $password='';
    public $reservationId;
    public $pciUrl='';
    public $value=0;
    public $balance=0;
    public $depositType;
    public $currentBalance=0;

    public function mount($reservationId, $balance, $depositType){
       $this->reservationId=$reservationId;
       $this->balance=$balance;
       $this->depositType=$depositType;
       $this->currentBalance=$balance;
   
    }
    public function render()
    {
        return view('livewire.finance.payment-tracker.multi-step-form');
    }

    public function firstStepSubmit(){
        
        $password=bcrypt($this->password);
        if (\Hash::check($this->password, auth()->user()->password)) {
            $reservation=Reservation::where('id', $this->reservationId)->first();
            $channexCard=$reservation->channex_cards;
            
            if ($channexCard) {
                $sessionUrl=config('services.channex.pci_base')."/session_tokens?api_key=".config('services.channex.pci_api_key');
                $card_session_data=[
                    "session_token"=>[
                        "scope"=>"card"
                    ]
                ];
    
                $sc_session_data=[
                    "session_token"=>[
                        "scope"=>"service_code"
                    ]
                ];
    
                try {
                    $client=new Client();
                    $card_session_request=$client->post($sessionUrl,  [
                        "headers"=>['Content-Type'=>'application/json'],
                        "body"=>json_encode($card_session_data)
                        ]
                        );
    
                        $card_result=json_decode($card_session_request->getBody(), true);
                        $card_session_key=$card_result['data']['attributes']['session_token'];
    
                        $client=new Client();
                        $sc_session_request=$client->post($sessionUrl,  [
                            "headers"=>['Content-Type'=>'application/json'],
                            "body"=>json_encode($sc_session_data)
                            ]
                            );
    
                        $sc_result=json_decode($sc_session_request->getBody(), true);
                        $sc_session_key=$sc_result['data']['attributes']['session_token'];
    
                        $this->pciUrl=config('services.channex.pci_base')."/show_card?card_token=". $channexCard."&session_token=".$card_session_key."&service_code_token=".$sc_session_key;
                        
                } catch (\Throwable $th) {
                    //throw $th;
                    $this->emit('error', $th->getMessage());
                    
                }
            }
            $this->currentStep=2;
            
        }else{
            $this->password="";
            $this->emit('error', 'wrong password!');
        }
    }

    public function submitSecondStep(){
        // dd($this->balance);
        $this->validate([
            'balance'=>'required|min:1|gt:0|lte:'.$this->currentBalance,
        ],[
            'balance.required'=>'Payment amount is required',
            'balance.gt'=>'Payment amount must be greater than zero',
            'balance.lt'=>"You can't charge more than guest balance",
        ]);

        $reservation=Reservation::find($this->reservationId);
        $newPayment=GuestAccommodationPayment::create([
            "value"=>$this->balance,
            "date"=>today()->toDateString(),
            "is_deposit"=>1,
            "comments"=>'',
            "reservation_id"=>$this->reservationId,
            "deposit_type_id"=>$this->depositType,
            "payment_method_id"=>$reservation->payment_method_id
        ]);

        Reservation::where('channex_cards', $reservation->channex_cards)->update(["channex_cards"=>'']);

        $this->currentStep=3;
    }

    public function cancel(){
        // $this->value='';
        // $this->pciUrl='';
        // $this->balance=0;
        // $this->depositType='';
        $this->reset('balance', 'pciUrl', 'balance', 'depositType');
        $this->dispatchBrowserEvent('closePciModel');
    }

   
}
