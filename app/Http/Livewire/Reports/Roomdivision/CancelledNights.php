<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\Reservation;
use App\Models\RoomType;
use Carbon\Carbon;

use Livewire\Component;

class CancelledNights extends Component
{
    public $selectedDate;
    public $year;
    public $chartdata;
    public $nightsCancelled;
    public $mode;
    public $roomtypes;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";
        $this->roomtypes=getHotelSettings()->room_types;
    }

    public function render()
    {
        $this->year=$this->selectedDate->year;
        $cdate=$this->selectedDate->day;
        $dataArray=[];
        $chartdata=[['Room Types', 'Cancelled Nights'],['', 0]];
        
        foreach ($this->roomtypes as $roomtype) {
            $item=[ucwords($roomtype->name)];
            $yearNights=0;
            for ($i=1; $i <=12 ; $i++) { 
                $startDate=$this->year.'-'.$i."-01";
                $startDate=Carbon::parse($startDate)->toDateString();
                if ($this->mode=="current") {
                    $endDate=$this->year."-".$i."-".$cdate;
                    $endDate=Carbon::parse($endDate)->toDateString();
                }else{
                    $endDate=Carbon::parse($startDate)->endOfMonth();
                }

                $cancelledNights=Reservation::join('daily_rates', 'daily_rates.reservation_id', '=', 'reservations.id')
                                             ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                             ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                             ->whereBetween('date', [$startDate, $endDate])
                                             ->where('room_type_id', $roomtype->id)
                                             ->where(function($query){
                                                    $query->where('reservations.status','=', 'Cancelled')
                                                        ->orWhere('reservations.channex_status','=', 'cancelled');
                                                })
                                             ->count();
                array_push($item, (int)$cancelledNights);
                $yearNights+=(int)$cancelledNights;
    
            }
            array_push($dataArray, $item);
            array_push($chartdata, [$roomtype->name, $yearNights]);
        }
        array_push($chartdata, ['', 0]);
        $this->chartdata=$chartdata;
        $this->nightsCancelled=$dataArray;
        $this->selectedDate=$this->selectedDate->toDateString();
        $this->dispatchBrowserEvent('cnChanged');
        return view('livewire.reports.roomdivision.cancelled-nights');
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
