<?php

namespace App\Http\Livewire\Reports\B2b;
use App\Models\BookingAgency;
use App\Models\DailyRate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Livewire\Component;

class CancellationRevenue extends Component
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
        $this->agencies=getHotelSettings()->booking_agencies;
      }

    public function render()
    {
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

                $totalMonthRevenue=DailyRate::join('reservations', 'reservations.id', '=', 'daily_rates.reservation_id')

                                    ->whereBetween('date',[$startDate, $endDate])
                                    ->where(function($query){
                                        $query->where('status', 'Cancelled')
                                              ->orWhere('channex_status', 'cancelled');
                                    })
                                    ->where('booking_agency_id', '=', $agencyId)
                                    ->sum('price');
                $totalMonthRevenue1=showPriceWithCurrency($totalMonthRevenue);
                $result[$i]=$totalMonthRevenue1;
                $item=['v'=>(float)$totalMonthRevenue, 'f'=>$totalMonthRevenue1];
                if ($i==1) {
                    array_push($jandata, $item);
                  }else if ($i==2) {
                    array_push($febdata, $item);
                  }else if ($i==3) {
                     array_push($marchData, $item);
                  }else if ($i==4) {
                     array_push($aprData, $item);
                  }else if ($i==5) {
                     array_push($mayData, $item);
                  }else if ($i==6) {
                     array_push($juneData, $item);
                  }else if ($i==7) {
                     array_push($julyData, $item);
                  }else if ($i==8) {
                     array_push($augData, $item);
                  }else if ($i==9) {
                     array_push($sepData, $item);
                  }else if ($i==10) {
                     array_push($octData, $item);
                  }else if ($i==11) {
                     array_push($novData, $item);
                  }else if ($i==12) {
                     array_push($decData, $item);
                  }

            }
            $dataArray[]=$result;

        }

            $chartdata=[$firstRow, $jandata, $febdata, $marchData, $aprData, $mayData, $juneData, $julyData, $augData, $sepData, $octData, $novData, $decData];
            $this->selectedDate=$this->selectedDate->toDateString();
            $this->channels=$dataArray;
            $this->chartdata=$chartdata;
            $this->dispatchBrowserEvent('crevenueChanged');
        return view('livewire.reports.b2b.cancellation-revenue');
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
