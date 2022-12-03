<?php

namespace App\Http\Livewire\Reports\Kpi;
use App\Models\Availability;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Collection;

use Livewire\Component;

class Occupancy extends Component
{
    public $totalRooms;
    public $totalSoldRooms;
    public $totalOutOfOrder;
    public $averageOccupancy;
    public $startDate;
    public $endDate;
    public $roomtype;
    public $chartdata;
    public $statistics;
    public collection $roomtypeCollection;

    public function mount(){
        $currenDate=today();
        $nextDate=$currenDate->copy()->addDays(30);
        $this->startDate=$currenDate->toDateString();
        $this->endDate=$nextDate->toDateString();
        $this->roomtype="all";
        $this->roomtypeCollection=getHotelSettings()->room_types()->where('type_status', 1)->get();
    }

    public function setValues($start, $end, $roomtype){
        $this->startDate=$start;
        $this->endDate=$end;
        $this->roomtype=$roomtype;
    }

    public function render()
    {
        $totalSoldRooms=0;
        $totalOutOfOrder=0;
        $totalRooms=0;
        $totalDays=0;
        $totalOccupancy=0;
        $chartdata=[['Date', 'Occupancy Rate', 'Occupancy Rate']];
        $statistics=[];
        $startDate=$this->startDate;
        $endDate=$this->endDate;
        if ($this->roomtype=="all") {
            $countRooms=Room::join('room_types', 'room_types.id', '=', 'rooms.room_type_id')->where('room_types.hotel_settings_id', getHotelSettings()->id)->where('room_types.type_status', 1)->where('rooms.status', 'Enabled' )->count();
        }else{
            $countRooms=Room::join('room_types', 'room_types.id', '=', 'rooms.room_type_id')->where('room_types.hotel_settings_id', getHotelSettings()->id)->where('room_types.type_status', 1)->where('rooms.status', 'Enabled' )->where('rooms.room_type_id', $this->roomtype)->count();
        }
        
        while ($startDate<=$endDate) {
            if ($this->roomtype=="all") {
                
                $roomsold=Availability::join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')->join('rooms', 'rooms.id', '=', 'availabilities.room_id')->where('room_types.hotel_settings_id', getHotelSettings()->id)->where('room_types.type_status', 1)->where('rooms.status', 'Enabled' )->where('date', $startDate)->where('reservation_id', 'NOT LIKE', 'a%')->count();
                $ooo=Availability::join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')->join('rooms', 'rooms.id', '=', 'availabilities.room_id')->where('room_types.hotel_settings_id', getHotelSettings()->id)->where('room_types.type_status', 1)->where('rooms.status', 'Enabled' )->where('date', $startDate)->where('reservation_id', 'LIKE', 'a%')->count();

            }else{
                $roomsold=Availability::join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')->join('rooms', 'rooms.id', '=', 'availabilities.room_id')->where('room_types.hotel_settings_id', getHotelSettings()->id)->where('room_types.type_status', 1)->where('rooms.status', 'Enabled' )->where('rooms.room_type_id', $this->roomtype)->where('date', $startDate)->where('reservation_id', 'NOT LIKE', 'a%')->count();
                $ooo=Availability::join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')->join('rooms', 'rooms.id', '=', 'availabilities.room_id')->where('room_types.hotel_settings_id', getHotelSettings()->id)->where('room_types.type_status', 1)->where('rooms.status', 'Enabled' )->where('rooms.room_type_id', $this->roomtype)->where('date', $startDate)->where('reservation_id', 'LIKE', 'a%')->count();

            }
            $availableRoom=$countRooms-$ooo;
            if ($roomsold==0 || $availableRoom==0) {
                $occupancy=0;
            }else{
                $occupancy=((int)$roomsold/(int)$availableRoom)*100;
            }

            
            $occupancy=number_format((float)$occupancy, 2, '.', '');
            array_push($chartdata, [$startDate, (float)$occupancy, (float)$occupancy]);
            array_push($statistics, [$startDate, $countRooms, $roomsold, $ooo, $occupancy]);
            $totalOccupancy+=(float)$occupancy;
            $totalSoldRooms+=(int)$roomsold;
            $totalOutOfOrder+=(int)$ooo;
            $totalRooms+=(int)$countRooms;
            $totalDays++;
            $startDate=Carbon::parse($startDate)->addDay()->toDateString();
        }


        if ($totalOccupancy==0 || $totalRooms==0) {
            $averageOccupancy=0;
        }else{
            $averageOccupancy=(float)$totalOccupancy/(int)$totalRooms;
        }
        $averageOccupancy=number_format(($averageOccupancy), 2, '.', '');
        $this->averageOccupancy=$averageOccupancy;
        $this->totalRooms=$totalRooms;
        $this->totalOutOfOrder=$totalOutOfOrder;
        $this->totalSoldRooms=$totalSoldRooms;
        $this->chartdata=$chartdata;
        $this->statistics=$statistics;

        $this->dispatchBrowserEvent('occcontentChanged');
        return view('livewire.reports.kpi.occupancy');
    }
}
