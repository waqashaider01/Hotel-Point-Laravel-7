<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\Availability;
use Carbon\Carbon;

use Livewire\Component;

class Roomrate extends Component
{
    public $selectedDate;
    public $year;
    public $chartdata;
    public $ratesold;
    public $ratetypes;
    public $mode;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";

    }

    public function render()
    {
        $startYear=$this->selectedDate->copy()->startOfYear()->toDateString();
        $endYear=$this->selectedDate->copy()->endOfYear()->toDateString();
        $ratetypes=Availability::join('reservations', 'availabilities.reservation_id', '=', 'reservations.id')->join('rate_types', 'rate_types.id', '=', 'reservations.rate_type_id')->where('reservations.hotel_settings_id', getHotelSettings()->id)->whereBetween('date', [$startYear, $endYear])->groupBy('rate_types.id', 'rate_types.name', 'rate_types.reference_code')->get(['rate_types.id', 'rate_types.name', 'rate_types.reference_code']);
        $this->year=$this->selectedDate->year;
        $cdate=$this->selectedDate->day;
        $dataArray=[];
        $chartdata=[['Rate Types', 'Nights Sold'],['', 0]];
            
        foreach ($ratetypes as $ratetype) {
            $item=[ucwords($ratetype->name)."( ".$ratetype->reference_code." )"];
            $yearrateSold=0;
             for ($i=1; $i <=12 ; $i++) { 
                $startDate=$this->year.'-'.$i."-01";
                $startDate=Carbon::parse($startDate)->toDateString();
                if ($this->mode=="current") {
                    $endDate=$this->year."-".$i."-".$cdate;
                    $endDate=Carbon::parse($endDate)->toDateString();
                }else{
                    $endDate=Carbon::parse($startDate)->endOfMonth();
                }

                $roomSoldMonth=Availability::join('reservations', 'availabilities.reservation_id', '=', 'reservations.id')->where('rate_type_id', $ratetype->id)->whereBetween('date', [$startDate, $endDate])->count();
                array_push($item, (int)$roomSoldMonth);
                $yearrateSold+=(int)$roomSoldMonth;

             }
             array_push($dataArray, $item);
             array_push($chartdata, [$ratetype->name, $yearrateSold]);
        }
        $this->ratesold=$dataArray;
        array_push($chartdata, ['', 0]);
        $this->chartdata=$chartdata;
        $this->selectedDate=$this->selectedDate->toDateString();
        $this->dispatchBrowserEvent('rateChanged');
        return view('livewire.reports.roomdivision.roomrate');
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
