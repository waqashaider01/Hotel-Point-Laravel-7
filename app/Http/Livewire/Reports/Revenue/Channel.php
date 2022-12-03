<?php

namespace App\Http\Livewire\Reports\Revenue;

use App\Models\BookingAgency;
use App\Models\Reservation;
use App\Models\DailyRate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

class Channel extends Component
{
    public $selectedDate;
    public $mode='current';
    public  $chartdata;
    public $year;
    public $channels;
    public collection $agencies;

    public function mount(){
      $this->selectedDate=today();
      $this->mode="current";
      $this->agencies = getHotelSettings()->booking_agencies;
    }
    public function render(){

            $this->createData();
            $this->dispatchBrowserEvent('channelChanged');
            return view('livewire.reports.revenue.channel');


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


   public function createData(){
        $this->year=$this->selectedDate->year;
        $cdate=$this->selectedDate->day;
        $dataArray=[];
        $firstRow=["Month"];
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
        foreach ($this->agencies as $agency){
            $result=[];
            $agencyId=$agency->id;
            $agencyName=$agency->name;
            $result['channel']=$agencyName;
            $firstRow[]=$agencyName;

            for ($i=1; $i <=12 ; $i++) {
                $startDate=$this->year.'-'.$i."-01";
                $startDate=Carbon::parse($startDate)->toDateString();
                if ($this->mode=="current") {
                    $endDate=$this->year."-".$i."-".$cdate;
                    $endDate=Carbon::parse($endDate)->toDateString();
                }else{
                    $endDate=Carbon::parse($startDate)->endOfMonth();
                }

                $monthRevenueTotal=DailyRate::join('reservations', 'reservations.id', '=', 'daily_rates.reservation_id')

                                    ->whereBetween('date',[$startDate, $endDate])
                                    ->where('status', '!=', 'Cancelled')
                                    ->where('channex_status', '!=', 'cancelled')
                                    ->where('booking_agency_id', '=', $agencyId)
                                    ->sum('price');
                $monthRevenueTotal1=showPriceWithCurrency($monthRevenueTotal);
                $result[$i]=$monthRevenueTotal1;
                if ($i==1) {
                    $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                    array_push($jandata, $item);
                  }else if ($i==2) {
                    $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                    array_push($febdata, $item);
                  }else if ($i==3) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($marchData, $item);
                  }else if ($i==4) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($aprData, $item);
                  }else if ($i==5) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($mayData, $item);
                  }else if ($i==6) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($juneData, $item);
                  }else if ($i==7) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($julyData, $item);
                  }else if ($i==8) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($augData, $item);
                  }else if ($i==9) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($sepData, $item);
                  }else if ($i==10) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($octData, $item);
                  }else if ($i==11) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($novData, $item);
                  }else if ($i==12) {
                     $item=['v'=>(float)$monthRevenueTotal, 'f'=>$monthRevenueTotal1];
                     array_push($decData, $item);
                  }

            }
            $dataArray[]=$result;

        }

            $chartdata=[$firstRow, $jandata, $febdata, $marchData, $aprData, $mayData, $juneData, $julyData, $augData, $sepData, $octData, $novData, $decData];
            $this->selectedDate=$this->selectedDate->toDateString();
            $this->channels=$dataArray;
            $this->chartdata=$chartdata;

   }




}
