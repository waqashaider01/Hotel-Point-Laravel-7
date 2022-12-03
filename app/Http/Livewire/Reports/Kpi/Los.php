<?php

namespace App\Http\Livewire\Reports\Kpi;
use App\Models\Availability;
use Carbon\Carbon;

use Livewire\Component;

class Los extends Component
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
            $totalNights=0;
            $totalReservations=0;
            $losmonth=0;
            $getLos=Availability::selectRaw('count(*) as total')
                                ->join('reservations', 'reservations.id', '=', 'availabilities.reservation_id')
                                ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                ->whereBetween('date',[$startDate, $endDate])
                                ->where('reservations.status', '!=', 'Cancelled')
                                ->where('channex_status', '!=', 'cancelled')
                                ->where('type_status', 1)
                                ->where('rooms.status', 'Enabled')
                                ->groupBy('availabilities.reservation_id')
                                ->get();
            
            if ($getLos->isEmpty()) {
                
            }else{
                foreach($getLos as $los){
                    $totalNights+=(int)$los['total'];
                    $totalReservations++;
                }
            }

            if ($totalNights==0 || $totalReservations==0) {
                
            }else{
                $losmonth=(int)$totalNights/(int)$totalReservations;
            }
            $losmonth= number_format((float)$losmonth, 2, '.', '');
            array_push($actualData, $losmonth);
            

        }
        $this->actual=$actualData;
        $this->selectedDate=$this->selectedDate->toDateString();
        $this->dispatchBrowserEvent('losChanged');
        return view('livewire.reports.kpi.los');
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
