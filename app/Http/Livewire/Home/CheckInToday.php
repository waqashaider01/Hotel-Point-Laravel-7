<?php

namespace App\Http\Livewire\Home;

use App\Models\Availability;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Template;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CheckInToday extends Component
{
    public $query = '';
    public $template;
    public $templates;
    public $selected_reservation;
    public $search_date;
    public $search_text;

    public function mount()
    {
        $this->templates = collect();
    }

    public function render()
    {
        $reservations = getHotelSettings()->reservations()->with(['guest', 'room', 'rate_type', 'booking_agency', 'country'])
            ->where('status', 'NOT LIKE', 'Cancelled')->where('channex_status', 'NOT LIKE', 'Cancelled')
            ->whereDate('arrival_date', Carbon::today())
            ->where("reservations.arrival_date", "!=", DB::raw("reservations.departure_date"))
            ->whereNull('actual_checkin');

        if ($this->search_text) {
            $reservations = $reservations->where(function ($query) {
                $query->whereHas('room', fn($q) => $q->where('number', 'LIKE', '%' . $this->search_text . '%'))
                    ->orWhereHas('guest', fn($query) => $query->where('full_name', 'like', '%' . $this->search_text . '%'));
            });
        }

        $reservations = $reservations->get();
        $results = [];
        foreach ($reservations as $reservation) {
            $data = [];
            $data['reservation'] = $reservation;
            $data['statuses'] = getStatusesAndValues($reservation->id);
            $data['tooltip'] = $this->setTooltip($data['statuses']);
            $data['moonTooltip'] = $this->setMoonTooltip($reservation);
            $results[] = $data;
        }

        return view('livewire.home.check-in-today')->with([
            'results' => $results,
        ]);
    }

    public function setCheckin(Reservation $reservation)
    {
        $this->selected_reservation = $reservation;
        $this->templates = getHotelSettings()->templates->where('type', 'checkin');
        
    }

    public function setNoshow(Reservation $reservation)
    {
        $this->selected_reservation = $reservation;
    }

    public function saveCheckin()
    {
        $this->validate(['template' => 'required']);
        $getTodayCheckoutReservation = Reservation::where('room_id', $this->selected_reservation->room_id)->whereDate('check_out', today()->toDateString())->whereNull('actual_checkout')->where('status', 'Arrived')->count();
        if ($getTodayCheckoutReservation > 0) {
            throw ValidationException::withMessages(['reservation' => 'You cannot checkin guest.']);
        } else {
            $this->selected_reservation->status = 'Arrived';
            $this->selected_reservation->actual_checkin = now()->toDateString();
            $this->selected_reservation->save();
            $template = Template::find($this->template);
            $guest_name = $this->selected_reservation->guest->full_name;
            $body = $template->fillTemplateContentBody($this->selected_reservation->id);
            $pdfContent = PDF::loadHTML($body)->output();
            $this->emit('dataSaved', 'Checked in successfully.');
            $this->emit('windowReload');
            return response()->streamDownload(
                fn() => print($pdfContent),
                $guest_name . ".pdf"
            );
        }
        return redirect(request()->header('Referer'));
    }

    public function resetFields()
    {
        $this->query = '';
        $this->search_text = '';
        $this->search_date = '';
    }

    public function saveNoshow()
    {
        try {
            DB::beginTransaction();
                $hotel = getHotelSettings();
                $propertyId = $hotel->active_property()->property_id;

                $checkin = $this->selected_reservation->arrival_date;
                $checkindate = $checkin;
                $roomtypeid = $this->selected_reservation->room->room_type_id;
                $channexroomtypeid = $this->selected_reservation->room->room_type->channex_room_type_id;
                $checkout = Carbon::parse($this->selected_reservation->departure_date);
                $checkin = Carbon::parse($checkin)->addDay();
                $nights = $checkout->diffInDays($checkin);

                $this->selected_reservation->arrival_date = $checkin->toDateString();
                $this->selected_reservation->status = 'No Show';
                $this->selected_reservation->overnights = $nights;
                $this->selected_reservation->reservation_amount = $this->selected_reservation->daily_rates()->where("date", ">=", $checkin->toDateString())->where("date", "<", $checkout->toDateString())->sum('price');
                $this->selected_reservation->save();

                Availability::where("reservation_id", $this->selected_reservation->id)->where("date", $checkindate)->delete();

                DB::commit();

                if ($this->selected_reservation->room->room_type->channex_room_type_id) {
                    // update availability
                    $availabilityUrl = config('services.channex.api_base') . "/availability";

                    $availableRooms = getAvailability($this->selected_reservation->room->room_type, $checkindate);
                    $availdata = ["values" => [
                        [
                            "property_id" => $propertyId,
                            "room_type_id" => $channexroomtypeid,
                            "date" => $checkindate,
                            "availability" => $availableRooms,
                        ],
                    ]];

                    try {
                        $client = new Client;
                        $client->post($availabilityUrl, [
                            'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                            'body' => json_encode($availdata),
                        ]);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }

                    
                }
                
                if ($this->selected_reservation->booking_agency->channel_code=="BDC")
                 {
                    // mark as noshow to channex
                    $payload=[
                        "no_show_report"=>[
                            "waived_fees"=>false
                        ]
                     ];

                     try {
                        
                        $client = new Client;

                        $client->post(config('services.channex.api_base') . "/"."bookings/". $this->selected_reservation->channex_booking_id."/no_show", [
                            'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
                            'body' => json_encode($payload),
                        ]);

                     } catch (\Throwable $th) {
                        //throw $th;
                     }
                   
                }

                $this->emit('dataSaved', 'Reservation Was Successfully Moved.');
           
            return redirect(request()->header('Referer'));
        } catch (\Exception$e) {
            $this->emit('showWarning', $e->getMessage());
        }
    }

    private function setTooltip(array $statuses): string
    {
        return '
            <div class="d-flex flex-column">
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Accomodation</b> '. showPriceWithCurrency($statuses['accom_total']) .' </div>
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Overnight Tax</b> '. showPriceWithCurrency($statuses['overnight_total']) .' </div>
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Services</b> '. showPriceWithCurrency($statuses['extras_total']) .' </div>
            </div>
        ';
    }

    public function setMoonTooltip(Reservation $reservation): string {
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
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Check In</b> '. $actual_checkin .' </div>
                <div class="w-100 d-flex justify-content-between"> <b class="pr-8">Check Out</b> '. $actual_checkout.' </div>
            </div>
        ';
    }

}
