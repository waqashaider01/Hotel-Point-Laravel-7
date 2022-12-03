<?php

namespace App\Http\Livewire\Reports\Revenue;
use App\Models\ReservationExtraCharge;
use Carbon\Carbon;

use Livewire\Component;

class Service extends Component
{
    public $date;
    public $year;
    public $chartdata;
    public $mode='current';
    public $services;

    public function mount(){
        $this->date=today();
        $this->mode="current";
      
    }
    public function render()
    {
        $this->computeData();
        $this->dispatchBrowserEvent('serviceChanged');
        return view('livewire.reports.revenue.service');
    }

    public function setdate($date){
        $this->date= Carbon::parse($date);
        $this->mode="current";
      }
    
 
     public function setyear($year){
       $date=$year."-01-01";
       $this->date= Carbon::parse($date);
       $this->mode="full";
    }

    public function computeData(){
        $this->year=$this->date->year;
        $cdate=$this->date->day;
        $dataArray=[];
        $firstRow=["Month", "Services Revenue", "Services Revenue"];
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
        for ($i=1; $i <=12 ; $i++) {
                $monthlytotal=0;
                $startDate=$this->year.'-'.$i."-01";
                $startDate=Carbon::parse($startDate)->toDateString();
                if ($this->mode=="current") {
                    $endDate=$this->year."-".$i."-".$cdate;
                    $endDate=Carbon::parse($endDate)->toDateString();
                }else{
                    $endDate=Carbon::parse($startDate)->endOfMonth();
                } 
            
            $monthlytotal=ReservationExtraCharge::join('reservations', 'reservations.id', '=', 'reservation_extra_charges.reservation_id')->where('reservations.hotel_settings_id',getHotelSettings()->id)->whereBetween('date', [$startDate, $endDate])->sum('extra_charge_total');
                $monthlytotal1=showPriceWithCurrency($monthlytotal);
                if ($i==1) {
                    $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                    array_push($jandata, $item);
                    array_push($jandata, $item);
                  }else if ($i==2) {
                    $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                    array_push($febdata, $item);
                    array_push($febdata, $item);
                  }else if ($i==3) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($marchData, $item);
                     array_push($marchData, $item);
                  }else if ($i==4) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($aprData, $item);
                     array_push($aprData, $item);
                  }else if ($i==5) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($mayData, $item);
                     array_push($mayData, $item);
                  }else if ($i==6) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($juneData, $item);
                     array_push($juneData, $item);
                  }else if ($i==7) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($julyData, $item);
                     array_push($julyData, $item);
                  }else if ($i==8) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($augData, $item);
                     array_push($augData, $item);
                  }else if ($i==9) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($sepData, $item);
                     array_push($sepData, $item);
                  }else if ($i==10) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($octData, $item);
                     array_push($octData, $item);
                  }else if ($i==11) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($novData, $item);
                     array_push($novData, $item);
                  }else if ($i==12) {
                     $item=['v'=>(float)$monthlytotal, 'f'=>$monthlytotal1];
                     array_push($decData, $item);
                     array_push($decData, $item);
                  }
            array_push($dataArray, $monthlytotal1);
                                    
        }
        $chartdata=[$firstRow, $jandata, $febdata, $marchData, $aprData, $mayData, $juneData, $julyData, $augData, $sepData, $octData, $novData, $decData];
        $this->chartdata=$chartdata;
        $this->services=$dataArray;
        $this->date=$this->date->toDateString();
        
    }


}
