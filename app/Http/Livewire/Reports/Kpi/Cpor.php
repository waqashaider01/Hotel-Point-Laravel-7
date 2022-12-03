<?php

namespace App\Http\Livewire\Reports\Kpi;
use App\Models\Availability;
use App\Models\HotelBudget;
use App\Models\OpexData;
use Carbon\Carbon;

use Livewire\Component;

class Cpor extends Component
{
    public $selectedDate; 
    public $mode='current';
    public  $chartdata;
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
        $this->dispatchBrowserEvent('cporChanged');
        return view('livewire.reports.kpi.cpor');
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
        $forecastData=[];
        $forecastData1=[];
        
        $occupiedRoomNight=[0,0,0,0,0,0,0,0,0,0,0,0];
        $randd=[0,0,0,0,0,0,0,0,0,0,0,0];
        
        $getForecast=HotelBudget::where('hotel_settings_id', getHotelSettings()->id)->whereIn('type', [1,5])->whereIn('category', [3,4])->where('budget_year', $this->year)->get();
        if ($getForecast->isEmpty()) {
            
        }else{
            $getForecast=$getForecast[0];
            if ($getForecast['type']=='1' && $getForecast['category']=='3') {
                $occupiedRoomNight[0]=$getForecast['january'];
                $occupiedRoomNight[1]=$getForecast['february'];
                $occupiedRoomNight[2]=$getForecast['march'];
                $occupiedRoomNight[3]=$getForecast['april'];
                $occupiedRoomNight[4]=$getForecast['may'];
                $occupiedRoomNight[5]=$getForecast['june'];
                $occupiedRoomNight[6]=$getForecast['july'];
                $occupiedRoomNight[7]=$getForecast['august'];
                $occupiedRoomNight[8]=$getForecast['september'];
                $occupiedRoomNight[9]=$getForecast['october'];
                $occupiedRoomNight[10]=$getForecast['november'];
                $occupiedRoomNight[11]=$getForecast['december'];
            }else if ($getForecast['type']=='5' && $getForecast['category']=='4') {
                $randd[0]=$getForecast['january'];
                $randd[1]=$getForecast['february'];
                $randd[2]=$getForecast['march'];
                $randd[3]=$getForecast['april'];
                $randd[4]=$getForecast['may'];
                $randd[5]=$getForecast['june'];
                $randd[6]=$getForecast['july'];
                $randd[7]=$getForecast['august'];
                $randd[8]=$getForecast['september'];
                $randd[9]=$getForecast['october'];
                $randd[10]=$getForecast['november'];
                $randd[11]=$getForecast['december'];
            }else{}
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

            $forecastMonth=0;
            if ($occupiedRoomNight[$i]==0 || $randd[$i]==0) {
                
            }else{
                $forecastMonth=(float)$randd[$i]/(int)$occupiedRoomNight[$i];
            }

            $forecastMonth=number_format((float)$forecastMonth, 2, '.', '');
            $forecastMonth1=showPriceWithCurrency($forecastMonth);
            array_push($forecastData, $forecastMonth);
            array_push($forecastData1, $forecastMonth1);
            
            $totalRoomsold=Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
                                        ->join('room_types', 'room_types.id', '=', 'availabilities.room_type_id')
                                        ->where('room_types.hotel_settings_id', getHotelSettings()->id)
                                        ->whereBetween('date',[$startDate, $endDate])
                                        ->where('availabilities.id', 'NOT LIKE', 'a%')
                                        ->where('type_status', 1)
                                        ->where('rooms.status', 'Enabled')
                                        ->count();
            $opexRevenue=OpexData::where('hotel_settings_id', getHotelSettings()->id)->where('cos_id', '1')->whereBetween('date', [$startDate, $endDate])->sum('amount');
            
            if ($totalRoomsold==0 || $opexRevenue==0) {
                $monthRevenueTotal=0;
            }else{
                $monthRevenueTotal=(float)$opexRevenue/(int)$totalRoomsold;
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
