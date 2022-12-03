<?php

namespace App\Http\Livewire\Rooms;

use Livewire\Component;
use App\Models\RoomType;

class RoomsTypeAndRooms extends Component
{
    public function render()
    {
        $roomtypes = getHotelSettings()->room_types()->select(
            'id',
            'name',
            'channex_room_type_id',
            'reference_code',
            'type_status'
        )->orderBy('position')->get();

        return view('livewire.rooms.rooms-type-and-rooms',compact('roomtypes'));
    }
}
