<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\Availability;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Collection;

use Livewire\Component;

class Availabilities extends Component
{
    public $startDate;
    public $endDate;
    public $selectedRoomtype;
    public $roomtypeRow;
    public $headcol;
    public collection $roomtypeCollection;

    public function mount(){
        $this->startDate=today();
        $this->endDate=$this->startDate->copy()->addDays(30);
        $this->selectedRoomtype="all";
        $this->roomtypeCollection=getHotelSettings()->room_types()->where('type_status', 1)->get();
    }

    public function setValues($start, $end, $roomtype){
        $this->startDate=Carbon::parse($start);
        $this->endDate=Carbon::parse($end);
        $this->selectedRoomtype=$roomtype;
    }
    public function render()
    {
        $start=$this->startDate->copy();
        $end=$this->endDate->copy();
        $roomtypeRow="";
        $startMonth=$this->startDate->copy()->format('M');
        $endMonth=$this->endDate->copy()->format('M');
        $headcol="<th class='bold-black' >".$startMonth."-".$endMonth."</th>";
        
        while ($start<=$end) {
            $headcol.="<th class='bold-black' >".$start->format('d')."</th>";
            $start=$start->addDay();
        }

        if ($this->selectedRoomtype=="all") {
            $roomtypes=$this->roomtypeCollection;
        }else{
            $roomtypes=getHotelSettings()->room_types()->where('id', $this->selectedRoomtype)->get();
        }
        foreach ($roomtypes as $roomtype) {
            $roomtypeRow.="<tr class='text-center no-border'><td>".ucwords($roomtype->name)."</td>";
            $totalRooms=Room::active()->where('room_type_id', $roomtype->id)->count();
            $start=$this->startDate->copy();
            while ($start<=$end) {
                $occupied=Availability::join('rooms', 'availabilities.room_id', 'rooms.id')->where('availabilities.room_type_id', $roomtype->id)->where('date', $start->copy()->format('Y-m-d'))->where('status', 'Enabled')->count();
                $available=(int)$totalRooms-(int)$occupied;
                $roomtypeRow.="<td class='idcolor'>".$available."</td>";
                $start=$start->addDay();
            }
            $roomtypeRow.="</tr>";
            $rooms=Room::active()->where('room_type_id', $roomtype->id)->get();
            foreach ($rooms as $room) {
                $start=$this->startDate->copy();
                $roomtypeRow.="<tr class='text-center thin-bottom-border bg-white'><td class='idcolor'>".$room->number."</td>";
                while ($start<=$end) {
                    $isAvailable=Availability::where('room_id', $room->id)->where('date', $start->copy()->format('Y-m-d'))->count();
                    if ($isAvailable>0) {
                        $roomtypeRow.="<td><i class='fas fa-times-circle uncheck'></i></td>";
                    }else{
                        $roomtypeRow.="<td><i class='fas fa-check-circle checkcell'></i></td>";
                    }
                    $start=$start->addDay();
                    
                }
                $roomtypeRow.="</tr>";
            }

        


        }

        $this->roomtypeRow=$roomtypeRow;
        $this->headcol=$headcol;
        $this->startDate=$this->startDate->toDateString();
        $this->endDate=$this->endDate->toDateString();
        return view('livewire.reports.roomdivision.availabilities');
    }
}
