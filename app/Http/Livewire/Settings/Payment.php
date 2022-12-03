<?php

namespace App\Http\Livewire\Settings;

use App\Models\HotelSetting;
use App\Models\PaymentMethod;
use App\Models\PaymentMode;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Payment extends Component
{
    public PaymentMode $selected_mode;
    public PaymentMethod $selected_method;
    public HotelSetting $bank;
    public $newPaymentMethod;
    public $methods;
    public $modes;

    protected array $rules = [
        'bank.bank_name' => 'required',
        'bank.bank_status' => 'required',
        'bank.swift_code' => 'required',
        'bank.iban' => 'required',
        'selected_mode.name' => 'required',
        'selected_method.name' => 'required',
        'selected_method.commission_percentage' => 'required',
        'selected_method.is_card_type' => 'required',
        'selected_method.channex_id' => 'required',
        'selected_method.oxygen_id' => 'nullable',
    ];

    public function mount()
    {
        $this->bank = getHotelSettings();
        $this->methods = $this->bank->payment_methods;
        $this->modes = $this->bank->payment_modes;
    }

    public function render()
    {
        return view('livewire.settings.payment')->with([
            'settings' => $this->bank,
        ]);
    }

    public function onMethodUpdate()
    {
        $this->selected_method->channex_id = PaymentMethod::$types[$this->selected_method->name]['channex_code'];
    }

    public function setMode(PaymentMode $mode)
    {
        $this->selected_mode = $mode;
    }

    public function setMethod(PaymentMethod $method)
    {
        $this->newPaymentMethod = false;
        $this->selected_method = $method;
    }

    public function setNewMode()
    {
        $this->selected_mode = new PaymentMode();
    }

    public function setNewMethod()
    {
        $this->newPaymentMethod = true;
        $this->selected_method = new PaymentMethod();
    }

    public function saveMode()
    {
        $this->validate([
            'selected_mode.name' => 'required',
        ]);
        $this->selected_mode->hotel_settings_id = $this->bank->id;
        $this->selected_mode->save();
        $this->emit('dataSaved');
    }

    public function saveMethod()
    {
        $rules = [
            'selected_method.commission_percentage' => 'required',
            'selected_method.channex_id' => 'required',
            'selected_method.is_card_type' => 'required',
        ];
        if ($this->newPaymentMethod) {
            $rules['selected_method.name'] = ['required', Rule::notIn($this->methods->pluck('name')->toArray())];
        }
        $this->validate($rules);
        $this->selected_method->hotel_settings_id = $this->bank->id;
        try {
            if ($this->newPaymentMethod && $this->bank->oxygen_api_key) {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->bank->oxygen_api_key,
                ])->post(config('services.oxygen.api_base')."/payment-methods", [
                    "title_gr" => PaymentMethod::$types[$this->selected_method->name]['name_gr'] ?? $this->selected_method->name,
                    "title_en" => PaymentMethod::$types[$this->selected_method->name]['name_en'] ?? $this->selected_method->name,
                    "mydata_code" => (int)$this->selected_method->is_card_type ? 1 : 3,
                    "status" => true
                ]);

                if ($response->json('id')) {
                    $this->selected_method->oxygen_id = $response->json('id');
                    $this->selected_method->save();
                    $this->methods = $this->bank->payment_methods;
                }
                
            } else {
                $this->selected_method->save();
            }
            $this->emit('dataSaved', "Payment Saved Successfully!");
        } catch (\Throwable $th){
            $this->emit('showError', $th->getMessage());
        }
    }

    public function synPaymentMethodsWithOxygen()
    {
        $status = syncOxygenApiPaymentMethods();

        if($status['status'] == 'success'){
            $this->methods = $this->bank->payment_methods()->get();
        }

        $this->emit($status['emit_type'], $status['message']);
    }

    public function saveBank()
    {
        $this->validate([
            'bank.bank_name' => 'required',
            'bank.swift_code' => 'required',
            'bank.iban' => 'required',
        ]);
        $this->bank->save();
        $this->emit('dataSaved', 'Bank Saved Successfully!');
    }
    public function bankStatusUpdate()
    {
        $this->validate([
            'bank.bank_status' => 'required',
        ]);
        $this->bank->save();
        $this->emit('dataSaved','Bank Status Updated!');
    }
}
