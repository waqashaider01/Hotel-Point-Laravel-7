<?php

namespace App\Http\Livewire\Finance\PaymentTracker;

use App\Models\HotelSetting;
use GuzzleHttp\Client;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use App\Models\ReservationDeposit;
use App\Models\GuestAccommodationPayment;
use Illuminate\Support\Facades\DB;

class Tracker extends Component
{
    public $totalcharge;
    public $prepaymentCharge;
    public $prepayments;
    public $charge_a;
    public $charge_b;
    public $date='';
    public $firstCharges;
    public $secondCharges;
    public $paymentMethods;
    public $greenDates='';
    public $currentReservationId;
    public $currentStep=1;
    public $balance=0;
    public $depositType=1;
    
    
    public function mount(){
        $this->date=today()->toDateString();
        $this->paymentMethods = getHotelSettings()->payment_methods;
    }

   
    public function render(Request $request)
    {
        $prepaymentArray=[];
        $firstChargeArray=[];
        $secondChargeArray=[];
        $totalcharge=0;
        $prepaymentCharge=0;
        $charge_a=0;
        $charge_b=0;
        $prepayments=Reservation::join('reservation_deposits', 'reservations.id', '=', 'reservation_deposits.reservation_id')
                                  ->join('booking_agencies', 'booking_agencies.id', '=', 'reservations.booking_agency_id')
                                  ->where('has_prepayment', 1)
                                  ->where('prepayment_value','>', 0)
                                  ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                  ->where('prepayment_date_to_pay', $this->date)->get(['reservations.id', 'reservation_deposits.prepayment_value', 'booking_code', 'booking_agencies.name', 'reservations.status', 'reservation_amount', 'reservations.payment_method_id' ]);
        foreach ($prepayments as $prepayment) {
            $prepaymentValue=(float)$prepayment['prepayment_value'];
            $deposit=(float)GuestAccommodationPayment::where('reservation_id', $prepayment->id)->sum('value');
            if ($deposit>=$prepaymentValue) {
                $balance=0;
            }else{
                $balance=$prepaymentValue-$deposit;
            }
            $deposit=$prepaymentValue-$balance;
            $totalcharge+=(float)$prepaymentValue;
            $prepaymentCharge+=(float)$prepaymentValue;

            array_push($prepaymentArray, array("id"=>$prepayment->id, "prepayment"=>$prepaymentValue, "booking_code"=>$prepayment->booking_code, "agency"=>$prepayment->name, "status"=>$prepayment->status, "payment_method_id"=>$prepayment->payment_method_id, "total"=>$prepayment->reservation_amount, "deposit"=>$deposit, "balance"=>$balance));


        }

        $firstCharges=Reservation::join('reservation_deposits', 'reservations.id', '=', 'reservation_deposits.reservation_id')
                                  ->join('booking_agencies', 'booking_agencies.id', '=', 'reservations.booking_agency_id')
                                  ->where('has_first_charge', 1)
                                  ->where('first_charge_value','>', 0)
                                  ->where('first_charge_date_to_pay', $this->date)
                                  ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                  ->get(['reservations.id', 'reservation_deposits.prepayment_value', 'reservation_deposits.first_charge_value', 'booking_code', 'booking_agencies.name', 'reservations.status', 'reservation_amount', 'reservations.payment_method_id' ]);
        foreach ($firstCharges as $firstCharge) {
            $firstChargeValue=(float)$firstCharge->first_charge_value;
            $prepaymentValue=(float)$firstCharge->prepayment_value;
            $supposedDeposit=$prepaymentValue+$firstChargeValue;
            $deposit=(float)GuestAccommodationPayment::where('reservation_id', $firstCharge->id)->sum('value');
            if ($deposit==0) {
                $balance=$firstChargeValue;
            }else if ($deposit>=$supposedDeposit) {
                $balance=0;
            }else if ($deposit<$supposedDeposit && $deposit>=$prepaymentValue) {
                $balance=$supposedDeposit-$deposit;
            }else if($deposit<$supposedDeposit && $deposit<$prepaymentValue){
                $balance=$firstChargeValue;
            }else{}
            $deposit=$firstChargeValue-$balance;
            $totalcharge+=(float)$firstChargeValue;
            $charge_a+=(float)$firstChargeValue;

            array_push($firstChargeArray, array("id"=>$firstCharge->id, "firstCharge"=>$firstChargeValue, "booking_code"=>$firstCharge->booking_code, "agency"=>$firstCharge->name, "status"=>$firstCharge->status, "payment_method_id"=>$firstCharge->payment_method_id, "total"=>$firstCharge->reservation_amount, "deposit"=>$deposit, "balance"=>$balance));


        }

        $secondCharges=Reservation::join('reservation_deposits', 'reservations.id', '=', 'reservation_deposits.reservation_id')
                                  ->join('booking_agencies', 'booking_agencies.id', '=', 'reservations.booking_agency_id')
                                  ->where('has_second_charge', 1)
                                  ->where('second_charge_value','>', 0)
                                  ->where('second_charge_date_to_pay', $this->date)
                                  ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                  ->get(['reservations.id', 'reservation_deposits.prepayment_value', 'reservation_deposits.first_charge_value', 'reservation_deposits.second_charge_value', 'booking_code', 'booking_agencies.name', 'reservations.status', 'reservation_amount', 'reservations.payment_method_id' ]);
        foreach ($secondCharges as $secondCharge) {
            $secondChargeValue=(float)$secondCharge->second_charge_value;
            $firstChargeValue=(float)$secondCharge->first_charge_value;
            $prepaymentValue=(float)$secondCharge->prepayment_value;
            $supposedDeposit=$prepaymentValue+$firstChargeValue+$secondChargeValue;
            $sumUpToFirstCharge=$prepaymentValue+$firstChargeValue;
            $deposit=(float)GuestAccommodationPayment::where('reservation_id', $secondCharge->id)->sum('value');
            if ($deposit==0) {
                $balance=$secondChargeValue;
            }else if ($deposit>=$supposedDeposit) {
                $balance=0;
            }else if ($deposit<$supposedDeposit && $deposit>=$sumUpToFirstCharge) {
                $balance=$supposedDeposit-$deposit;
            }else if($deposit<$supposedDeposit && $deposit<$sumUpToFirstCharge){
                $balance=$secondChargeValue;
            }else{}
            $deposit=$secondChargeValue-$balance;
            $totalcharge+=(float)$secondChargeValue;
            $charge_b+=(float)$secondChargeValue;

            array_push($secondChargeArray, array("id"=>$secondCharge->id, "secondCharge"=>$secondChargeValue, "booking_code"=>$secondCharge->booking_code, "agency"=>$secondCharge->name, "status"=>$secondCharge->status, "payment_method_id"=>$secondCharge->payment_method_id, "total"=>$secondCharge->reservation_amount, "deposit"=>$deposit, "balance"=>$balance));


        }
        
        $this->prepayments=$prepaymentArray;
        $this->firstCharges=$firstChargeArray;
        $this->secondCharges=$secondChargeArray;
        $this->totalcharge=showPriceWithCurrency($totalcharge);
        $this->prepaymentCharge=showPriceWithCurrency($prepaymentCharge);
        $this->charge_a=showPriceWithCurrency($charge_a);
        $this->charge_b=showPriceWithCurrency($charge_b);
       
        
        return view('livewire.finance.payment-tracker.tracker');
    }

    public function setDate($date){
        $this->date=$date;
        
    }

    public function setSameDate(){
        $this->date=$this->date;
        
    }

    public function updatedCurrentReservationId(){
        if ($this->currentReservationId) {
            $this->openModel();
        }
    }

    public function openModel(){
        $this->dispatchBrowserEvent('openPciModel');
    }

    

   

   


}
