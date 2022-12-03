<?php
declare(strict_types=1);

namespace App\Http\Livewire\Finance\DailyCashier;

use App\Models\GuestAccommodationPayment;
use App\Models\GuestExtrasPayment;
use App\Models\ReservationExtraCharge;
use Illuminate\Support\Collection;
use Livewire\Component;

class FrontDesk extends Component
{
    public string $date;
    public Collection $deposits; 
    public Collection $cash;
    public Collection $credit_cards;
    public Collection $debtors;
    public Collection $service_cash;
    public Collection $service_credit_cards;
    public Collection $room_charges;


    public function render()
    {
        return view('livewire.finance.daily-cashier.front-desk');
    } 

    public function mount($date) 
    {
        $this->date = $date;
        $hotel_id = getHotelSettings()->id;

        $this->deposits = GuestAccommodationPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('is_deposit', 1)->get();
        $this->cash = GuestAccommodationPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('is_deposit', 0)->where('payment_method_id', 1)->get();
        $this->credit_cards = GuestAccommodationPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('is_deposit', 0)->whereHas('payment_method', fn($q) => $q->where('is_card_type', 1))->get();
        $this->debtors = GuestAccommodationPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('is_deposit', 0)->where('payment_method_id', 6)->get();

        $this->service_cash = GuestExtrasPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->where('payment_method_id', 1)->get();
        $this->service_credit_cards = GuestExtrasPayment::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->whereHas('payment_method', fn($q) => $q->where('is_card_type', 1))->get();
        $this->room_charges = ReservationExtraCharge::whereDate('date', $this->date)->whereHas("reservation", fn($q) => $q->where('hotel_settings_id', $hotel_id))->get();
        
    }


}
