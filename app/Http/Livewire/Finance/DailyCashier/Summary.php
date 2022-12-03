<?php

namespace App\Http\Livewire\Finance\DailyCashier;

use App\Models\CashRegister;
use App\Models\Document;
use App\Models\GuestAccommodationPayment;
use App\Models\GuestExtrasPayment;
use App\Models\GuestOvernightTaxPayment;
use App\Models\HotelSetting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Summary extends Component
{
    public string $cash_sum = '';
    public string $card_sum = '';
    public string $deposit_sum = '';
    public string $debtor_sum = '';
    public string $service_cash_sum = '';
    public string $service_card_sum = '';
    public string $overnight_cash_sum = '';
    public string $overnight_card_sum = '';
    public string $password = '';
    public $register_cash = 0;
    public $register_balance = 0;
    public $register;
    public bool $is_open_register = false;
    public bool $is_close_register = false;
    public string $date;

    public function render()
    {
        return view('livewire.finance.daily-cashier.summary');
    }

    public function mount($date)
    {
        $this->date = $date;
        $hotel_id = getHotelSettings()->id;
        $this->register = getHotelSettings()->cash_registers()->whereDate('date', $date)->where('status', 'open')->first();
        $closed_register = getHotelSettings()->cash_registers()->whereDate('date', $date)->where('status', 'close')->first();
        
        $this->deposit_sum = GuestAccommodationPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('is_deposit', 1)->sum('value');
        $this->cash_sum = GuestAccommodationPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('is_deposit', 0)->where('payment_method_id', 1)->sum('value');
        $this->card_sum = GuestAccommodationPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('is_deposit', 0)->whereHas('payment_method', fn($q) => $q->where('is_card_type', 1))->sum('value');
        $this->debtor_sum = GuestAccommodationPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('is_deposit', 0)->where('payment_method_id', 6)->sum('value');
        
        $this->service_cash_sum = GuestExtrasPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('payment_method_id', 1)->sum('value');
        $this->service_card_sum = GuestExtrasPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->whereHas('payment_method', fn($q) => $q->where('is_card_type', 1))->sum('value');
        
        $this->overnight_cash_sum = GuestOvernightTaxPayment::whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->whereDate('date', $this->date)->where('payment_method_id', 1)->sum('value');
        $this->overnight_card_sum = GuestOvernightTaxPayment::whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->whereDate('date', $this->date)->whereHas('payment_method', fn($q) => $q->where('is_card_type', 1))->sum('value');
        
        if ($this->register && $this->register->status == 'open') {
            $this->is_open_register = true;
            $this->register_cash = $this->register->reg_cash;
        }else if($closed_register && $closed_register->status == 'close'){
            $this->is_close_register = true;
            $this->register_cash = $closed_register->reg_cash;
        }
       
        $credit_note_refundable_total = getHotelSettings()->documents()->whereDate('print_date', $date)->where('document_type_id', 6)->sum('total');
        $special_annulling_total = getHotelSettings()->documents()->whereDate('print_date', $date)->where('document_type_id', 2)->sum('total');
        $refundable_total = $credit_note_refundable_total + $special_annulling_total;
        $balance_to_delivery = $this->cash_sum + $this->service_cash_sum + $this->overnight_cash_sum;
        $this->register_balance = $balance_to_delivery - $refundable_total;
    }

    public function closeRegister()
    {
        $this->validate([
            'password' => ['required'],
        ]);
        if (Hash::check($this->password, getHotelSettings()->cashier_pass)) {
            $this->register->status = 'close';
            $this->register->save();
            $this->emit('dataSaved', 'Cashier closed Successfully');
        } else {
            $this->emit('showWarning', 'Wrong Password! Try Again');
        } 

    }
}
