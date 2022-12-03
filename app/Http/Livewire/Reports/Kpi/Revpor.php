<?php

namespace App\Http\Livewire\Reports\Kpi;
use App\Models\ReservationExtraCharge;
use App\Models\HotelBudget;
use App\Models\Availability;
use App\Models\Room;
use Carbon\Carbon;

use Livewire\Component;

class Revpor extends Component
{
    public $selectedDate; 
    public $mode='current';
    public $year;
    public $actual;
    public $forecast;
    public $actual1;
    public $forecast1;
    public $difference;
    
    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";
        
      }

    public function render()
    {
        $this->generateData();
        $this->dispatchBrowserEvent('revporChanged');
        return view('livewire.reports.kpi.revpor');
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

    public function generateData(){
        $this->year=$this->selectedDate->year;
        $cdate=$this->selectedDate->day;
        $actualData=[];
        $actualData1=[];
        $difference=[];
        $forecastData1=[];
        $forecastData=[0,0,0,0,0,0,0,0,0,0,0,0];
        
        $getForecast=getHotelSettings()->hotel_budgets()->where('type', 1)->where('category', 4)->where('budget_year', $this->year)->get();
        if ($getForecast->isEmpty()) {
            
        }else{
                $row=$getForecast[0];
            
                $forecastData[0]=$row['january'];
                $forecastData[1]=$row['february'];
                $forecastData[2]=$row['march'];
                $forecastData[3]=$row['april'];
                $forecastData[4]=$row['may'];
                $forecastData[5]=$row['june'];
                $forecastData[6]=$row['july'];
                $forecastData[7]=$row['august'];
                $forecastData[8]=$row['september'];
                $forecastData[9]=$row['october'];
                $forecastData[10]=$row['november'];
                $forecastData[11]=$row['december'];
            
        }
        
        
        for ($i=0; $i <12 ; $i++) { 
            $month=$i+1;
            $startDate=$this->year.'-'.$month."-01";
            $startDate=Carbon::parse($startDate)->toDateString();
            if ($this->mode=="current") {
                $endDate=$this->year."-".$month."-".$cdate;
                $endDate=Carbon::parse($endDate)->toDateString();
            }else{
                $endDate=Carbon::parse($startDate)->endOfMonth();
            }

            $forecastMonth=$forecastData[$i];
            

            $forecastMonth1=showPriceWithCurrency($forecastMonth);
            array_push($forecastData1, $forecastMonth1);
            
            $getActualData=Availability::selectRaw('count(*) as totalnights, sum(price) as monthRev')
                                        ->join('daily_rates', 'daily_rates.reservation_id', '=', 'availabilities.reservation_id')
                                        ->join('reservations', 'reservations.id', '=', 'availabilities.reservation_id')
                                        ->join('rooms', 'rooms.id', '=', 'availabilities.room_id')
                                        ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
                                        ->join('rate_types', 'rate_types.id', '=', 'reservations.rate_type_id')
                                        ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                        ->whereBetween('availabilities.date',[$startDate, $endDate])
                                        ->whereIn('reservations.status', ['Arrived', 'CheckedOut'])
                                        ->where('type_status', 1)
                                        ->where('rooms.status', 'Enabled')
                                        ->get();
            $getActualData=$getActualData[0];
            $monthrevenue=$getActualData['monthRev'];
            $totalnights=$getActualData['totalnights'];

            $extraCharges=ReservationExtraCharge::join('extra_charges', 'reservation_extra_charges.extra_charge_id', '=', 'extra_charges.id')
                                                     ->join('extra_charges_types', 'extra_charges.extra_charge_type_id', '=', 'extra_charges_types.id')
                                                     ->join('reservations', 'reservations.id', '=', 'reservation_extra_charges.reservation_id')
                                                     ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                                     ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                                     ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                                     ->whereBetween('reservation_extra_charges.date', [$startDate, $endDate])
                                                     ->where('type_status', 1)
                                                     ->where('rooms.status', 'Enabled')
                                                     ->sum('extra_charge_total');

            $totalCharge=(float)$monthrevenue+(float)$extraCharges;
            
            if ($totalCharge==0 || $totalnights==0) {
                $monthRevenueTotal=0;
            }else{
                $monthRevenueTotal=(float)$totalCharge/(int)$totalnights;
            }

            $monthRevenueTotal=number_format((float)$monthRevenueTotal, 2, '.', '');
            $monthRevenueTotal1=showPriceWithCurrency($monthRevenueTotal);
            array_push($actualData, $monthRevenueTotal);
            array_push($actualData1, $monthRevenueTotal1);
            
            $monthdifferance=0;
            if($forecastMonth==0 && $monthRevenueTotal==0){
                    $monthdifferance=0;
            }else if($forecastMonth==0 && $monthRevenueTotal!=0){
                    $monthdifferance=100;
            }else if($forecastMonth!==0 && $monthRevenueTotal==0){
                    $monthdifferance=$monthdifferance-100;
                    $monthdifferance=number_format((float)$monthdifferance, 2, '.', '');
            }else{

                    $monthdifferance=(float)$monthRevenueTotal/(float)$forecastMonth;
                    $monthdifferance=$monthdifferance*100;
                    $monthdifferance=$monthdifferance-100;
                    $monthdifferance=number_format((float)$monthdifferance, 2, '.', '');
            }
            if ($monthdifferance<0) {
                $color='red';
            }else{
                $color='green';
            }
            array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));

            
            
        }
        $this->forecast=$forecastData;
        $this->forecast1=$forecastData1;
        $this->actual=$actualData;
        $this->actual1=$actualData1;
        $this->difference=$difference;
        $this->selectedDate=$this->selectedDate->toDateString();



    }
}
