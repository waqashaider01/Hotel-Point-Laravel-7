<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\Reservation;
use App\Models\Comment;
use Carbon\Carbon;

use Livewire\Component;

class Arrivals extends Component
{
    public $selectedDate;
    public $arrivals;

    public function mount(){
        $this->selectedDate=today()->toDateString();
    }
    public function render()
    {
        $arrivals=[];
        $reservations=Reservation::join('booking_agencies', 'reservations.booking_agency_id', '=', 'booking_agencies.id')->join('rooms', 'reservations.room_id', '=', 'rooms.id')->join('guests', 'reservations.guest_id', '=', 'guests.id')->where('reservations.hotel_settings_id', getHotelSettings()->id)->where('arrival_date', $this->selectedDate)->get(['reservations.id', 'reservations.room_id', 'full_name', 'number', 'booking_agencies.name', 'adults', 'kids', 'infants', 'reservations.comment']);
        foreach ($reservations as $row) {
            $arrivalComment='<ul>';
               $comments=Comment::where('room_id', $row['room_id'])->where('type', 'fd')->get();
               foreach ($comments as $comment) {
                if ($comment->description) {
                    $arrivalComment.="<li>".$comment->description."</li>";
                }
                
               }
               if ($row['comment']) {
                $arrivalComment.= "<li>". $row['comment']."</li>";
               }
               $arrivalComment.="</ul>";
               
               array_push($arrivals, [$row['id'], $row['full_name'], $row['number'], $row['name'], $row['adults'], $row['kids'], $row['infants'], $arrivalComment]);
        }

        $this->arrivals=$arrivals;
        return view('livewire.reports.roomdivision.arrivals');
    }

    public function setdate($date){
        $this->selectedDate= Carbon::parse($date)->toDateString();
      }
}
