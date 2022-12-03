<?php

namespace App\Http\Livewire\Home;

use App\Models\Availability;
use App\Models\DailyRate;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomCondition;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Livewire\Component;

class Stats extends Component
{
    public $selected_reservation;
    public $selected_room;
    public $offer_status = 'Confirm';
    public $offer_search = '';
    public $hk_search = '';
    public $room_condition = '';

    public function mount()
    {
        $this->hk_search = today()->toDateString();
    }

    public function render()
    {
        $offers = getHotelSettings()->reservations()->where('status', 'Offer');
        if (isset($this->offer_search) && $this->offer_search != '') {
            $offers = $offers->where('id', 'LIKE', '%' . $this->offer_search . '%');
        }

        $house_keeping = getHotelSettings()->reservations()->select("reservations.*")->join('rooms', 'reservations.room_id', '=', 'rooms.id')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->where('rooms.status', 'Enabled')
            ->where('room_types.type_status', '1')
            ->where(function ($q) {
                $q->whereDate('reservations.arrival_date', $this->hk_search)
                    ->orWhereDate('reservations.departure_date', $this->hk_search)
                    ->orWhere(function ($query) {
                        $query->whereDate('reservations.arrival_date', '<', $this->hk_search)
                            ->whereDate('reservations.departure_date', '>', $this->hk_search);
                    });
            })->get();
        
        //Handle early checkouts
        $house_keeping_filtered = $house_keeping->reject(function ($hk, $key) {
            if ($hk->status == "CheckedOut" && Carbon::parse($this->hk_search) > Carbon::parse($hk->actual_checkout)) {
                return true;
            }
            return false;
        });

        return view('livewire.home.stats')->with([
            'offers' => $offers->get(),
            'house_keeping' => $house_keeping_filtered,
        ]);
    }

    public function setReservation($r_id)
    {
        $this->selected_reservation = Reservation::find($r_id);
    }

    public function setRoom($r_id)
    {
        $this->selected_reservation = Reservation::find($r_id);
        $this->selected_room = $this->selected_reservation->room;
    }

    public function updateOfferStatus()
    {
        $property = getHotelSettings()->active_property()->property_id;
        
        if ($this->offer_status == "Cancelled") {
            $this->selected_reservation->status = $this->offer_status;
            $this->selected_reservation->channex_status = "cancelled";
            $this->selected_reservation->save();

            Availability::where("reservation_id", $this->selected_reservation->id)->delete();
            RoomCondition::where("reservation_id", $this->selected_reservation->id)->delete();

            $totalRooms=Room::where('status', 'Enabled')->where('room_type_id', $this->selected_reservation->room->room_type->id)->count();
            $checkin=$this->selected_reservation->check_in;
            $checkout=$this->selected_reservation->check_out;
            $fulldata=[];
            // $hotel=Property::where('hotel_id', $this->selected_reservation->hotel_settings_id)->where('name', 'Channex')->first();
            while ($checkin<$checkout) {
                // add channel manager availability
                   $availableRooms=getAvailability($this->selected_reservation->room->room_type, $checkin);
                   $innerdata=[
               
                       "property_id"=> $property,
                       "room_type_id"=> $this->selected_reservation->room->room_type->channex_room_type_id,
                       "date"=> $checkin,
                       "availability"=> (int) $availableRooms
                       
                       ];
                       array_unshift($fulldata, $innerdata);

                       $checkin=Carbon::parse($checkin)->addDay()->toDateString();
            }
            // send availability to channex............
           $availData=["values"=>$fulldata];
           $availabilityUrl = config('services.channex.api_base') . "/availability";
           $client=new Client();
           $client->post($availabilityUrl, [
               'headers' => ['Content-Type' => 'application/json', 'user-api-key' => config('services.channex.api_key')],
               'body' => json_encode($availData),
           ]);


        } else {

            $this->selected_reservation->status = $this->offer_status;
            $this->selected_reservation->save();

        }
        $this->emit('dataSaved', "Reservation updated successfully");
        return;


    }

    public function saveRoomCondition()
    {
        $this->selected_room->room_conditions()->updateOrCreate(
            [
                'date' => $this->hk_search,
                'reservation_id' => $this->selected_reservation->id,
            ],
            [
                'status' => $this->room_condition,
            ]
        );
        $this->emit('dataSaved', 'Status changed successfully');
    }

}
