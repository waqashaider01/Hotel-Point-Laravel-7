<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Country extends Component
{
    public $guests;
    public $selectedDate;
    public $year;
    public $chartdata;
    public $mode;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";
      
    }
    
    public function render()
    {
        $this->year=$this->selectedDate->year;
        $dataArray=[];
        $chartdata=[['Country', 'Total Guests'], ['', 0]];
        if ($this->mode=="current") {
            $startDate=Carbon::parse($this->selectedDate)->startOfMonth()->toDateString();
            $endDate=Carbon::parse($this->selectedDate)->endOfMonth()->toDateString();
        }else{
            $startDate=Carbon::parse($this->selectedDate)->startOfYear()->toDateString();
            $endDate=Carbon::parse($this->selectedDate)->endOfYear()->toDateString();
        }
       
        $getData=DB::table('reservations')->select(DB::raw('sum(adults)+sum(kids)+sum(infants) as totalguests'), 'countries.name')
                            ->join('availabilities', 'reservations.id', '=', 'availabilities.reservation_id')
                            ->join('countries', 'countries.id', '=', 'reservations.country_id')
                            ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
                            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
                            ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                            ->whereBetween('availabilities.date', [$startDate, $endDate])
                            ->where(function($query){
                                $query->where('reservations.status','!=', 'Cancelled')
                                      ->orWhere('reservations.channex_status','!=', 'cancelled');
                            })
                            ->where('rooms.status','Enabled')
                            ->where('room_types.type_status', 1)
                            ->groupBy('countries.id', 'countries.name')
                            ->get();
        foreach ($getData as $row) {
            
               $totalGuest=$row->totalguests;
               $country=$row->name;
               array_push($dataArray, [$country, $totalGuest]);
               array_push($chartdata, [$country, (int)$totalGuest]);

        }
        array_push($chartdata, ['', 0]);
        $this->guests=$dataArray;
        $this->chartdata=$chartdata;
        $this->selectedDate=$this->selectedDate->toDateString();
        $this->dispatchBrowserEvent('countryChanged');
        return view('livewire.reports.roomdivision.country');
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
