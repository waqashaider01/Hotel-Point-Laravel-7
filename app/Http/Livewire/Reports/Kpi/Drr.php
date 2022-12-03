<?php

namespace App\Http\Livewire\Reports\Kpi;
use App\Models\DailyRate;
use Carbon\Carbon;

use Livewire\Component;

class Drr extends Component
{
    public $selectedDate; 
    public $mode='current';
    public  $chartdata;
    public $year;
    public $actual;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";
        
      }

    public function render()
    {
        $this->year=$this->selectedDate->year;
        $cdate=$this->selectedDate->day;
        $actualData=[];

        for ($i=1; $i <=12 ; $i++) { 
            $startDate=$this->year.'-'.$i."-01";
            $startDate=Carbon::parse($startDate)->toDateString();
            if ($this->mode=="current") {
                $endDate=$this->year."-".$i."-".$cdate;
                $endDate=Carbon::parse($endDate)->toDateString();
            }else{
                $endDate=Carbon::parse($startDate)->endOfMonth();
            }
            $pmsRevenue=0;
            $otherAgenciesRevenue=0;
            $drrRatio=0;
            $getrevenue=DailyRate::join('reservations', 'reservations.id', '=', 'daily_rates.reservation_id')
                                        ->join('booking_agencies', 'booking_agencies.id', '=', 'reservations.booking_agency_id')
                                        ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                        ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                        ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                        ->whereBetween('date',[$startDate, $endDate])
                                        ->where('reservations.status', '!=', 'Cancelled')
                                        ->where('channex_status', '!=', 'cancelled')
                                        ->where('type_status', 1)
                                        ->where('rooms.status', 'Enabled')
                                        ->get();
            
            if ($getrevenue->isEmpty()) {
                
            }else{
                foreach($getrevenue as $drr){
                    $channelCode=$drr['channel_code'];
                    $dailyrate=$drr['price'];
                    if ($channelCode=="CBE" || $channelCode=="OSA") {
                
                        $pmsRevenue+=(float)$dailyrate;
        
                   }else{
        
                        $otherAgenciesRevenue+=(float)$dailyrate;
                   }
                }
            }

            if ($pmsRevenue==0 || $otherAgenciesRevenue==0) {
                
            }else{
                $drrRatio=(float)$pmsRevenue/(float)$otherAgenciesRevenue;
            }
            $drrRatio= number_format((float)$drrRatio, 2, '.', '');
            array_push($actualData, $drrRatio);
            

        }
        $this->actual=$actualData;
        $this->selectedDate=$this->selectedDate->toDateString();
        $this->dispatchBrowserEvent('drrChanged');
        return view('livewire.reports.kpi.drr');
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
