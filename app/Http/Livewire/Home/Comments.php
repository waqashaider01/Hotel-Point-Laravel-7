<?php

namespace App\Http\Livewire\Home;

use App\Models\Comment;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Livewire\Component;

class Comments extends Component
{
    public string $type = 'hk';
    // public string $status = '';
    public array $res_id;
    // public string $reservation = '';
    public $room = '';
    public string $date = '';
    public string $comment = '';
    public $rooms;

    public function render()
    {
        /* SELECT * FROM `reservations` WHERE `check_in`='$cdate' OR  `check_in`>'$cdate' */
        $today = today()->toDateString();
        // if($this->date) {
        //     $today = $this->date;
        // }
        // if($this->status != ""){
        //     $reservations = getHotelSettings()->reservations();
        //     if ($this->status == 'Arrival') {
        //         $reservations = $reservations->whereDate('check_in', '>=', $today);
        //     } else if ($this->status == 'Accommodation') {
        //         $reservations = $reservations->whereDate('check_in', '<', $today)
        //             ->whereDate('check_out', '>', $today);
        //     } else if ($this->status == 'Departure') {
        //         $reservations = $reservations->whereDate('check_out', '<=', $today);
        //     }
        //     $this->res_id = $reservations->pluck('id')->toArray();
        // }else {
        //     $this->res_id = [];

        // }

        return view('livewire.home.comments');
    }

    public function mount()
    {
        // $this->res_id = array();
        $this->rooms=Room::join('room_types', 'rooms.room_type_id', '=', 'room_types.id')->where('hotel_settings_id', getHotelSettings()->id)->get(['rooms.id', 'rooms.number']);
        // dd($rooms);
    }

    // public function updatedReservation()
    // {
    //     $reservation = Reservation::find($this->reservation);
    //     if($reservation){
    //         $this->room = $reservation->room->number;
    //     }
    // }

    // public function updatedStatus()
    // {
    //     $this->reset('room','reservation', 'date');
    //     $today = today()->toDateString();
    //     $reservations = getHotelSettings()->reservations();
    //     if ($this->status == 'Arrival') {
    //         $reservations = $reservations->whereDate('check_in', '>=', $today);
    //     } else if ($this->status == 'Accommodation') {
    //         $reservations = $reservations->whereDate('check_in', '<', $today)
    //             ->whereDate('check_out', '>', $today);
    //     } else if ($this->status == 'Departure') {
    //         $reservations = $reservations->whereDate('check_out', '<=', $today);
    //     }
    //     $this->res_id = $reservations->pluck('id')->toArray();
    // }

    // public function updatedDate() {
    //     $this->reset('room','reservation');
    //     if($this->status != ""){
    //         $today = today()->toDateString();
    //         if($this->date != "") {
    //             $today = $this->date;
    //         }
    //         $reservations = getHotelSettings()->reservations();
    //         if ($this->status == 'Arrival') {
    //             $reservations = $reservations->whereDate('check_in', '>=', $today);
    //         } else if ($this->status == 'Accommodation') {
    //             $reservations = $reservations->whereDate('check_in', '<', $today)
    //                 ->whereDate('check_out', '>', $today);
    //         } else if ($this->status == 'Departure') {
    //             $reservations = $reservations->whereDate('check_out', '<=', $today);
    //         }
    //         $this->res_id = $reservations->pluck('id')->toArray();
    //     }else {
    //         $this->res_id = [];
    //     }
    // }

    public function saveComment() 
    {
        $this->validate([
            // 'status' => 'required',
            // 'reservation' => 'required',
            'room' => 'required',
            'date' => 'required',
            'comment' => 'required',
        ]);
        Comment::updateOrCreate([
            'type' => $this->type,
            'date' => $this->date,
            'room_id' => $this->room,
            // 'status' => $this->status,
        ], [
            'description' => $this->comment,
        ]);
        $this->reset('room', 'date','comment');
        $this->emit('dataSaved', 'Comment Saved Successfully');

    }
}
