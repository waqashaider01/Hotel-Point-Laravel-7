<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\RoomType;
use App\Models\Availability;
use Carbon\Carbon;

use Livewire\Component;

class Roomsold extends Component
{
    public $selectedDate;
    public $year;
    public $chartdata;
    public $roomsold;
    public $roomtypes;
    public $mode;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";

    }
    public function render()
    {
        $startYear=$this->selectedDate->copy()->startOfYear()->toDateString();
        $endYear=$this->selectedDate->copy()->endOfYear()->toDateString();
        $roomtypes=Roomtype::join('availabilities', 'availabilities.room_type_id', '=', 'room_types.id')->where('room_types.hotel_settings_id', getHotelSettings()->id)->whereBetween('date', [$startYear, $endYear])->groupBy('room_types.id', 'room_types.name')->get(['room_types.id', 'room_types.name']);
        $this->year=$this->selectedDate->year;
        $cdate=$this->selectedDate->day;
        $dataArray=[];
        $chartdata=[['Room Types', 'Rooms Sold'],['', 0]];
        foreach ($roomtypes as $roomtype) {
           
            $item=[$roomtype->name];
            $soldYear=0;
             for ($i=1; $i <=12 ; $i++) { 
                $startDate=$this->year.'-'.$i."-01";
                $startDate=Carbon::parse($startDate)->toDateString();
                if ($this->mode=="current") {
                    $endDate=$this->year."-".$i."-".$cdate;
                    $endDate=Carbon::parse($endDate)->toDateString();
                }else{
                    $endDate=Carbon::parse($startDate)->endOfMonth();
                }

                $roomSoldMonth=Availability::where('room_type_id', $roomtype->id)->whereBetween('date', [$startDate, $endDate])->count();
                array_push($item, (int)$roomSoldMonth);
                $soldYear+=(int)$roomSoldMonth;

             }
             array_push($dataArray, $item);
             array_push($chartdata, [$roomtype->name, $soldYear]);
        }
        array_push($chartdata, ['', 0]);
        $this->roomsold=$dataArray;
        $this->chartdata=$chartdata;
        $this->selectedDate=$this->selectedDate->toDateString();
        $this->dispatchBrowserEvent('roomsoldChanged');
        return view('livewire.reports.roomdivision.roomsold');
    }

    public function setdate($date){
        $this->selectedDate= Carbon::parse($date);
        $this->mode="current";
      }
    
 
     public function setyear($year){
        $date=$year."-01-01";
        $this->selectedDate= Carbon::parse($date);
        $this->mode="full";
        
    }
}
