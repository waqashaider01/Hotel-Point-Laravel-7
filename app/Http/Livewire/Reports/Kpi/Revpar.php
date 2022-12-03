<?php

namespace App\Http\Livewire\Reports\Kpi;
use App\Models\DailyRate;
use App\Models\HotelBudget;
use App\Models\Availability;
use App\Models\Room;
use Carbon\Carbon;

use Livewire\Component;

class Revpar extends Component
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
        $this->dispatchBrowserEvent('revparChanged');
        return view('livewire.reports.kpi.revpar');
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
        $totalRooms=0;
            
        $firstRow=["Month", 'Actual', 'Forecast'];
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
        $forecastArray=[];
        $availablerooms=[0,0,0,0,0,0,0,0,0,0,0,0];
        $operatingdays=[0,0,0,0,0,0,0,0,0,0,0,0];
        $averageDailyroom=[0,0,0,0,0,0,0,0,0,0,0,0];
        $occupiedRoomNights=[0,0,0,0,0,0,0,0,0,0,0,0];
        $getForecast=getHotelSettings()->hotel_budgets()->where('type', 1)->whereIn('category', [1,2,3,4])->where('budget_year', $this->year)->get();
        if ($getForecast->isEmpty()) {
            
        }else{
            foreach($getForecast as $row){
                if($row['category']=='2'){

                    $availablerooms[0]=$row['budget_january'];
                    $availablerooms[1]=$row['february'];
                    $availablerooms[2]=$row['march'];
                    $availablerooms[3]=$row['april'];
                    $availablerooms[4]=$row['may'];
                    $availablerooms[5]=$row['june'];
                    $availablerooms[6]=$row['july'];
                    $availablerooms[7]=$row['august'];
                    $availablerooms[8]=$row['september'];
                    $availablerooms[9]=$row['october'];
                    $availablerooms[10]=$row['november'];
                    $availablerooms[11]=$row['december'];
                    
                }else if($row['category']=='4'){

                    $averageDailyroom[0]=$row['january'];
                    $averageDailyroom[1]=$row['february'];
                    $averageDailyroom[2]=$row['march'];
                    $averageDailyroom[3]=$row['april'];
                    $averageDailyroom[4]=$row['may'];
                    $averageDailyroom[5]=$row['june'];
                    $averageDailyroom[6]=$row['july'];
                    $averageDailyroom[7]=$row['august'];
                    $averageDailyroom[8]=$row['september'];
                    $averageDailyroom[9]=$row['october'];
                    $averageDailyroom[10]=$row['november'];
                    $averageDailyroom[11]=$row['december'];
                    
                }else if($row['category']=='1'){

                    $operatingdays[0]=$row['january'];
                    $operatingdays[1]=$row['february'];
                    $operatingdays[2]=$row['march'];
                    $operatingdays[3]=$row['april'];
                    $operatingdays[4]=$row['may'];
                    $operatingdays[5]=$row['june'];
                    $operatingdays[6]=$row['july'];
                    $operatingdays[7]=$row['august'];
                    $operatingdays[8]=$row['september'];
                    $operatingdays[9]=$row['october'];
                    $operatingdays[10]=$row['november'];
                    $operatingdays[11]=$row['december'];
                    
                }else if($row['category']=='3'){

                    $occupiedRoomNights[0]=$row['january'];
                    $occupiedRoomNights[1]=$row['february'];
                    $occupiedRoomNights[2]=$row['march'];
                    $occupiedRoomNights[3]=$row['april'];
                    $occupiedRoomNights[4]=$row['may'];
                    $occupiedRoomNights[5]=$row['june'];
                    $occupiedRoomNights[6]=$row['july'];
                    $occupiedRoomNights[7]=$row['august'];
                    $occupiedRoomNights[8]=$row['september'];
                    $occupiedRoomNights[9]=$row['october'];
                    $occupiedRoomNights[10]=$row['november'];
                    $occupiedRoomNights[11]=$row['december'];
                    
                }else{}
            }
        }

        $totalRooms=Room::join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                ->where('hotel_settings_id', getHotelSettings()->id)
                                 ->where('type_status', 1)
                                 ->where('rooms.status', 'Enabled')
                                 ->count();

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
            $monthactual=0;
            $monthforcast=0;
            $monthdifferance=0;
            $accomodationRevenue=0;
            $oooRooms=0;
            $getrevenue=DailyRate::join('reservations', 'reservations.id', '=', 'daily_rates.reservation_id')
                                        ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                        ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                        ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                        ->whereBetween('date', [$startDate, $endDate])
                                        ->where('reservations.status', '!=', 'Cancelled')
                                        ->where('channex_status', '!=', 'cancelled')
                                        ->where('type_status', 1)
                                        ->where('rooms.status', 'Enabled')
                                        ->sum('price');
            $accomodationRevenue=$getrevenue;
            $oooRooms=Availability::join('rooms', 'rooms.id', '=', 'availabilities.room_id')
                                    ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                    ->where('room_types.hotel_settings_id', getHotelSettings()->id)
                                    ->where('availabilities.reservation_id', 'LIKE', 'a%')
                                    ->whereBetween('availabilities.date', [$startDate, $endDate])
                                    ->where('type_status', 1)
                                    ->where('rooms.status', 'Enabled')
                                    ->count();
            $availableRoom=$totalRooms-$oooRooms;
            if ($availableRoom==0 || $accomodationRevenue==0) {
                $monthactual=0;
            }else{
                $monthactual=(float)$accomodationRevenue/(int)$availableRoom;
                $monthactual=number_format((float)$monthactual, 2, '.', '');
            }

            $AvailableRoomNights=(int)$availablerooms[$i]*(int)$operatingdays[$i];
            $RoomRevenue=(int)$occupiedRoomNights[$i]*(float)$averageDailyroom[$i];
            if($AvailableRoomNights==0){

                $monthforcast=0;

            }else{

                $monthforcast=(float)$RoomRevenue/(int)$AvailableRoomNights;
                $monthforcast=number_format((float)$monthforcast, 2, '.', '');
                
            }
            $monthforcast1=showPriceWithCurrency($monthforcast);
            $monthactual1=showPriceWithCurrency($monthactual);
            array_push($actualData, $monthactual1);
            array_push($forecastArray, $monthforcast1);

            $monthdifferance=$this->calculateDiff($monthactual, $monthforcast);
            if ($monthdifferance<0) {
                $color='red';
            }else{
                $color='green';
            }
            array_push($difference, array('value'=>$monthdifferance, 'color'=>$color));
                                        
            
            if ($month==1) {
                array_push($jandata, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                array_push($jandata, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
                
              }else if ($month==2) {
                array_push($febdata, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                array_push($febdata, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==3) {
                 array_push($marchData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($marchData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==4) {
                 array_push($aprData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($aprData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
                 
              }else if ($month==5) {
                 array_push($mayData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($mayData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==6) {
                 array_push($juneData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($juneData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==7) {
                 array_push($julyData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($julyData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==8) {
                 array_push($augData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($augData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==9) {
                 array_push($sepData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($sepData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==10) {
                 array_push($octData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($octData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==11) {
                 array_push($novData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($novData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }else if ($month==12) {
                 array_push($decData, array('v'=>(float)$monthactual, 'f'=>$monthactual1));
                 array_push($decData, array('v'=>(float)$monthforcast, 'f'=>$monthforcast1));
              }
            
        }
       
        $chartdata=[$firstRow, $jandata, $febdata, $marchData, $aprData, $mayData, $juneData, $julyData, $augData, $sepData, $octData, $novData, $decData];
        $this->chartdata=$chartdata;
        $this->actual=$actualData;
        $this->difference=$difference;
        $this->forecast=$forecastArray;
        $this->selectedDate=$this->selectedDate->toDateString();



    }

    private function calculateDiff($actual, $forecast){
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
