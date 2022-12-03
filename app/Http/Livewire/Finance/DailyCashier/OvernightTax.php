<?php

namespace App\Http\Livewire\Finance\DailyCashier;

use App\Models\GuestOvernightTaxPayment;
use Illuminate\Support\Collection;
use Livewire\Component;

class OvernightTax extends Component
{
    public string $date;
    public Collection $cash;
    public Collection $credit_cards;

    public function render()
    {
        return view('livewire.finance.daily-cashier.overnight-tax');
    }
    public function mount($date)
    {
        $this->date = $date;
        $hotel_id = getHotelSettings()->id;

        $this->cash = GuestOvernightTaxPayment::whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->whereDate('date', $this->date)->where('payment_method_id',1)->get();
        $this->credit_cards = GuestOvernightTaxPayment::whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->whereDate('date', $this->date)->whereHas('payment_method', fn($q) => $q->where('is_card_type', 1))->get();
    }
}
