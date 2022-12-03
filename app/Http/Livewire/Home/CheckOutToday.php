<?php

namespace App\Http\Livewire\Home;

use App\Models\Country;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CheckOutToday extends Component
{
    public $template;
    public $templates;
    public $selected_reservation;
    public $selected_guest;
    public $countries;
    public $search_date;
    public $search_text;

    protected $rules = [
        'selected_guest.full_name' => 'required',
        'selected_guest.email' => 'required|email',
        'selected_guest.email_2' => '',
        'selected_guest.country_id' => 'required',
        'selected_guest.phone' => 'required',
        'selected_guest.mobile' => 'required',
        'selected_guest.postal_code' => 'required',
    ];

    public function mount()
    {
        $this->templates = collect();
        $this->countries = Country::all();
        $this->selected_guest = new Guest();
    }

    public function render()
    {

        $reservations = getHotelSettings()->reservations()->with(['guest', 'room', 'rate_type', 'booking_agency', 'country'])
            ->where(function ($mainQuery) {
                $mainQuery->where(function ($query) {
                    $query->where("reservations.arrival_date", "=", DB::raw("reservations.departure_date"))
                        ->where("reservations.status", "=", "No Show");
                });
                $mainQuery->orWhere(function ($query) {
                    $query->whereBetween("reservations.departure_date", [Carbon::today()->subDays(30)->format('Y-m-d'), Carbon::today()->format('Y-m-d')])
                        ->where("reservations.status", "=", "Arrived");
                });
                $mainQuery->orWhere(function ($query) {
                    $query->whereNotNull("actual_checkout")
                        ->where("reservations.status", "=", "Arrived");
                });
            });

        if ($this->search_text) {
            $reservations = $reservations->where(function ($query) {
                $query->whereHas('room', fn($q) => $q->where('number', 'LIKE', '%' . $this->search_text . '%'))
                    ->orWhereHas('guest', fn($query) => $query->where('full_name', 'like', '%' . $this->search_text . '%'));
            });
        }

        $results = [];
        $reservations = $reservations->get();
        foreach ($reservations as $reservation) {
            $data = [];
            $data['statuses'] = getStatusesAndValues($reservation->id);
            $data['reservation'] = $reservation;
            $data['tooltip'] = $this->setTooltip($data['statuses']);
            $data['moonTooltip'] = $this->setMoonTooltip($reservation);
            $results[] = $data;
        }
        return view('livewire.home.check-out-today')->with([
            'results' => $results,
        ]);
    }

    public function resetFields()
    {
        $this->search_text = '';
    }

    public function setCheckout(Reservation $reservation)
    {
        $this->selected_reservation = $reservation;
        $this->templates = Template::checkIn()->get();
    }

    public function setReservation(Reservation $reservation, $guest_id = 0)
    {
        $this->selected_reservation = $reservation;
        if ($guest_id != 0) {
            $this->selected_guest = Guest::find($guest_id);
        } else {
            $this->selected_guest = $this->selected_reservation->guest;
        }
    }

    public function saveCheckout()
    {
        $today = today();

        if (is_null($this->selected_reservation->actual_checkout)) {
            if ($today >= $this->selected_reservation->departure_day) {
                $this->selected_reservation->actual_checkout = $this->selected_reservation->departure_date;
                $this->selected_reservation->save();
                $this->emit('dataSaved', 'Checked out successfully.');
            } else {
                $this->selected_reservation->actual_checkout = $today->toDateString();
                if ($this->selected_reservation->save()) {
                    $this->emit('dataSaved', 'Checked out successfully.');
                } else {
                    $this->emit('showWarning', 'There was an error during checkout');
                    return;
                }
            }
        }
        $this->redirect(route('guest-reservation-fee', ['reservation' => $this->selected_reservation->id]));
    }

    public function updateGuest()
    {
        $this->validate();
        if (is_null($this->selected_guest->oxygen_id)) {
            create_oxygen_guest($this->selected_guest);
        }
        $this->selected_guest->save();
        $this->selected_reservation->checkin_guest_id = $this->selected_guest->id;
        $this->selected_reservation->save();
        $this->emit('dataSaved', 'Guest Details updated Successfully');
        $this->selected_guest = new Guest();
    }

    private function setTooltip(array $statuses): string
    {
        return '
            <div class="d-flex flex-column">
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Accomodation</b> ' . showPriceWithCurrency($statuses['accom_total']) . ' </div>
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Overnight Tax</b> ' . showPriceWithCurrency($statuses['overnight_total']) . ' </div>
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Services</b> ' . showPriceWithCurrency($statuses['extras_total']) . ' </div>
            </div>
        ';
    }

    public function setMoonTooltip(Reservation $reservation): string
    {
        if (is_null($reservation->actual_checkout)) {
            $actual_checkout = $reservation->departure_date ? $reservation->departure_date : today();
        } else {
            $actual_checkout = $reservation->actual_checkout;
        }
        if (is_null($reservation->actual_checkin)) {
            $actual_checkin = $reservation->arrival_date;
        } else {
            $actual_checkin = $reservation->actual_checkin;
        }
        return '
            <div class="d-flex flex-column">
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Check In</b> ' . $actual_checkin . ' </div>
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Check Out</b> ' . $actual_checkout . ' </div>
            </div>
        ';
    }

}