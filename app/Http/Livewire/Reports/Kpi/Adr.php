<?php

namespace App\Http\Livewire\Reports\Kpi;
use App\Models\DailyRate;
use App\Models\HotelBudget;
use Carbon\Carbon;

use Livewire\Component;

class Adr extends Component
{
    public $selectedDate; 
    public $mode='current';
    public  $chartdata;
    public $year;
    public $actual;
    public $forecast;
    public $difference;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";
        
      }
    
    public function render()
    {
        $this->generateData();
        $this->dispatchBrowserEvent('adrChanged');
        return view('livewire.reports.kpi.adr');
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
        $difference=[];
        $firstRow=["Month", 'Forecast', 'Actual'];
        $jandata=["Jan" ];
        $febdata=["Feb" ];
        $marchData=["Mar" ];
        $aprData=["Apr" ];
        $mayData=["May" ];
        $juneData=["Jun" ];
        $julyData=["Jul" ];
        $augData=["Aug" ];
        $sepData=["Sep" ];
        $octData=["Oct" ];
        $novData=["Nov" ];
        $decData=["Dec" ];
        $forecastArray=[0,0,0,0,0,0,0,0,0,0,0,0];
        $getForecast=HotelBudget::where('hotel_settings_id', getHotelSettings()->id)->where('type', 1)->where('category', 4)->where('budget_year', $this->year)->get();
        if ($getForecast->isEmpty()) {
            
        }else{
            $getForecast=$getForecast[0];
            $january=$getForecast['january'];
            $february=$getForecast['february'];
            $march=$getForecast['march'];
            $april=$getForecast['april'];
            $may=$getForecast['may'];
            $june=$getForecast['june'];
            $july=$getForecast['july'];
            $august=$getForecast['august'];
            $september=$getForecast['september'];
            $october=$getForecast['october'];
            $november=$getForecast['november'];
            $december=$getForecast['december'];
            $forecastArray=[$january, $february, $march, $april, $may, $june, $july, $august, $september, $october, $november, $december];

        }
        $janforecast=showPriceWithCurrency($forecastArray[0]);
        array_push($jandata, array('v'=>(float)$forecastArray[0], 'f'=>$janforecast));
        $febforecast=showPriceWithCurrency($forecastArray[1]);
        array_push($febdata, array('v'=>(float)$forecastArray[1], 'f'=>$febforecast));
        $marchforecast=showPriceWithCurrency($forecastArray[2]);
        array_push($marchData, array('v'=>(float)$forecastArray[2], 'f'=>$marchforecast));
        $aprforecast=showPriceWithCurrency($forecastArray[3]);
        array_push($aprData, array('v'=>(float)$forecastArray[3], 'f'=>$aprforecast));
        $mayforecast=showPriceWithCurrency($forecastArray[4]);
        array_push($mayData, array('v'=>(float)$forecastArray[4], 'f'=>$mayforecast));
        $juneforecast=showPriceWithCurrency($forecastArray[5]);
        array_push($juneData, array('v'=>(float)$forecastArray[5], 'f'=>$juneforecast));
        $julyforecast=showPriceWithCurrency($forecastArray[6]);
        array_push($julyData, array('v'=>(float)$forecastArray[6], 'f'=>$julyforecast));
        $augforecast=showPriceWithCurrency($forecastArray[7]);
        array_push($augData, array('v'=>(float)$forecastArray[7], 'f'=>$augforecast));
        $sepforecast=showPriceWithCurrency($forecastArray[8]);
        array_push($sepData, array('v'=>(float)$forecastArray[8], 'f'=>$sepforecast));
        $octforecast=showPriceWithCurrency($forecastArray[9]);
        array_push($octData, array('v'=>(float)$forecastArray[9], 'f'=>$octforecast));
        $novforecast=showPriceWithCurrency($forecastArray[10]);
        array_push($novData, array('v'=>(float)$forecastArray[10], 'f'=>$novforecast));
        $decforecast=showPriceWithCurrency($forecastArray[11]);
        array_push($decData, array('v'=>(float)$forecastArray[11], 'f'=>$decforecast));
        
        $this->forecast=[$janforecast, $febforecast, $marchforecast, $aprforecast, $mayforecast, $juneforecast, $julyforecast, $augforecast, $sepforecast, $octforecast, $novforecast, $decforecast];
        for ($i=1; $i <=12 ; $i++) { 
            $startDate=$this->year.'-'.$i."-01";
            $startDate=Carbon::parse($startDate)->toDateString();
            if ($this->mode=="current") {
                $endDate=$this->year."-".$i."-".$cdate;
                $endDate=Carbon::parse($endDate)->toDateString();
            }else{
                $endDate=Carbon::parse($startDate)->endOfMonth();
            }
            
            $getrevenue=DailyRate::selectRaw('count(*) as monthcount, sum(price) as monthRev')
                                        ->join('reservations', 'reservations.id', '=', 'daily_rates.reservation_id')
                                        ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                        ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                        ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                        ->whereBetween('date',[$startDate, $endDate])
                                        ->where('reservations.status', '!=', 'Cancelled')
                                        ->where('channex_status', '!=', 'cancelled')
                                        ->where('type_status', 1)
                                        ->where('rooms.status', 'Enabled')
                                        ->get();
            $getrevenue=$getrevenue[0];
            // dd($getrevenue);
            $monthrevenue=$getrevenue['monthRev'];
            $monthcount=$getrevenue['monthcount'];
            if ($monthrevenue==0 || $monthcount==0) {
                $monthRevenueTotal=0;
            }else{
                $monthRevenueTotal=$monthrevenue/$monthcount;
            }
            $monthRevenueTotal1=showPriceWithCurrency($monthRevenueTotal);
            array_push($actualData, $monthRevenueTotal1);
            $result[$i]=$monthRevenueTotal1;
            if ($i==1) {
                $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                array_push($jandata, $item);
                $monthforcast=$forecastArray[0];
                $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==2) {
                $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                array_push($febdata, $item);
                $monthforcast=$forecastArray[1];
                $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==3) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($marchData, $item);
                 $monthforcast=$forecastArray[2];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==4) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($aprData, $item);
                 $monthforcast=$forecastArray[3];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==5) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($mayData, $item);
                 $monthforcast=$forecastArray[4];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==6) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($juneData, $item);
                 $monthforcast=$forecastArray[5];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==7) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($julyData, $item);
                 $monthforcast=$forecastArray[6];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==8) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($augData, $item);
                 $monthforcast=$forecastArray[7];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==9) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($sepData, $item);
                 $monthforcast=$forecastArray[8];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==10) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($octData, $item);
                 $monthforcast=$forecastArray[9];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==11) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($novData, $item);
                 $monthforcast=$forecastArray[10];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }else if ($i==12) {
                 $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                 array_push($decData, $item);
                 $monthforcast=$forecastArray[11];
                 $monthdifferance=$this->calculateDiff($monthforcast, $monthRevenueTotal);
                 if ($monthdifferance<0) {
                    $color='red';
                }else{
                    $color='green';
                }
                array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
              }
            
        }

        $chartdata=[$firstRow, $jandata, $febdata, $marchData, $aprData, $mayData, $juneData, $julyData, $augData, $sepData, $octData, $novData, $decData];
        
        $this->chartdata=$chartdata;
        $this->actual=$actualData;
        $this->difference=$difference;
        $this->selectedDate=$this->selectedDate->toDateString();



    }

    private function calculateDiff($forecast, $actual){
        $monthdifferance=0;
        if($forecast==0 && $actual==0){
                $monthdifferance=0;
        }else if($forecast==0 && $actual!=0){
                $monthdifferance=100;
        }else if($forecast!==0 && $actual==0){
                $monthdifferance=$monthdifferance-100;
                $monthdifferance=number_format((float)$monthdifferance, 2, '.', '');
        }else{

                $monthdifferance=$actual/$forecast;
                $monthdifferance=$monthdifferance*100;
                $monthdifferance=$monthdifferance-100;
                $monthdifferance=number_format((float)$monthdifferance, 2, '.', '');
        }

        return $monthdifferance;
    }
}
