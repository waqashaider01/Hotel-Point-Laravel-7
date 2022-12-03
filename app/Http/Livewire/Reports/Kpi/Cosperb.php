<?php

namespace App\Http\Livewire\Reports\Kpi;
use App\Models\Availability;
use App\Models\OpexData;
use Carbon\Carbon;

use Livewire\Component;

class Cosperb extends Component
{
    public $selectedDate; 
    public $mode='current';
    public $year;
    public $actual;
    public $actual1;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";
        
      }

    public function render()
    {
        $this->year=$this->selectedDate->year;
        $cdate=$this->selectedDate->day;
        $actualData=[];
        $actualData1=[];

        for ($i=1; $i <=12 ; $i++) { 
            $startDate=$this->year.'-'.$i."-01";
            $startDate=Carbon::parse($startDate)->toDateString();
            if ($this->mode=="current") {
                $endDate=$this->year."-".$i."-".$cdate;
                $endDate=Carbon::parse($endDate)->toDateString();
            }else{
                $endDate=Carbon::parse($startDate)->endOfMonth();
            }
            $totalNights=0;
            $totalReservations=0;
            $reservationMonth=0;
            $monthAmount=0;
            $cosperb=0;

            $monthAmount=OpexData::where('cos_id', 1)->where('hotel_settings_id', getHotelSettings()->id)->whereBetween('date', [$startDate, $endDate])->sum('amount');
            $reservationMonth=Availability::join('reservations', 'reservations.id', '=', 'availabilities.reservation_id')->where('reservations.hotel_settings_id', getHotelSettings()->id)->whereBetween('date', [$startDate, $endDate])->groupBy('reservation_id')->count();
            
            if ($monthAmount==0 || $reservationMonth==0) {
                
            }else{
                $cosperb=(float)$monthAmount/(int)$reservationMonth;
            }
            $cosperb= number_format((float)$cosperb, 2, '.', '');
            $cosperb1=showPriceWithCurrency($cosperb);
            array_push($actualData, $cosperb);
            array_push($actualData1, $cosperb1);
            

        }
        $this->actual=$actualData;
        $this->actual1=$actualData1;
        $this->selectedDate=$this->selectedDate->toDateString();
        $this->dispatchBrowserEvent('cosperBChanged');
        return view('livewire.reports.kpi.cosperb');
    }

    public function set_date($date){
        $this->selectedDate= Carbon::parse($date);
        $this->mode="current";
      }
    
 
     public function set_year($year){
       $date=$year."-01-01";
       $this->selectedDate= Carbon::parse($date);
       $this->mode="full";
    }
}
