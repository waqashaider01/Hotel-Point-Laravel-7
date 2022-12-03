<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\Reservation;
use Carbon\Carbon;

use Livewire\Component;

class Inhouse extends Component
{
    public $selectedDate;
    public $inhouse;

    public function mount(){
        $this->selectedDate=today()->toDateString();
    }

    public function render()
    {
        $inhouse=[];
        $reservations=Reservation::join('rooms', 'reservations.room_id', '=', 'rooms.id')->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')->join('guests', 'reservations.guest_id', '=', 'guests.id')->where('reservations.hotel_settings_id', getHotelSettings()->id)->where('arrival_date','<', $this->selectedDate)->where('departure_date', '>', $this->selectedDate)->get(['reservations.id', 'full_name', 'number', 'room_types.name', 'adults', 'kids', 'infants']);
        foreach ($reservations as $row) {
               array_push($inhouse, [$row['id'], $row['full_name'], $row['number'], $row['name'], $row['adults'], $row['kids'], $row['infants'] ]);
        }

        $this->inhouse=$inhouse;
        return view('livewire.reports.roomdivision.inhouse');
    }

    public function setdate($date){
        $this->selectedDate= Carbon::parse($date)->toDateString();
      }
}
