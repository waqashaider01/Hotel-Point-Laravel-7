<?php

namespace App\Http\Livewire\Reports\B2b;
use App\Models\BookingAgency;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Livewire\Component;

class GuestsSegmentation extends Component
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

                $getTotalGuests=Reservation::selectRaw('sum(adults)+sum(kids)+sum(infants) as totalguests')
                                      ->join('availabilities', 'reservations.id', '=', 'availabilities.reservation_id')
                                      ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                      ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                      ->whereBetween('availabilities.date',[$startDate, $endDate])
                                      ->where(function($query){
                                        $query->where('reservations.status','!=', 'Cancelled')
                                              ->orWhere('channex_status','NOT LIKE', 'cancel%');
                                         })
                                      ->where('booking_agency_id', '=', $agencyId)
                                      ->where('type_status', 1)
                                      ->where('rooms.status', 'Enabled')
                                      ->get();
                $getTotalGuests=$getTotalGuests[0];
                $totalGuests=(int)$getTotalGuests['totalguests'];
                $result[$i]=$totalGuests;
                if ($i==1) {
                    array_push($jandata, (int)$totalGuests);
                  }else if ($i==2) {
                    array_push($febdata, (int)$totalGuests);
                  }else if ($i==3) {
                     array_push($marchData, (int)$totalGuests);
                  }else if ($i==4) {
                     array_push($aprData, (int)$totalGuests);
                  }else if ($i==5) {
                     array_push($mayData, (int)$totalGuests);
                  }else if ($i==6) {
                     array_push($juneData, (int)$totalGuests);
                  }else if ($i==7) {
                     array_push($julyData, (int)$totalGuests);
                  }else if ($i==8) {
                     array_push($augData, (int)$totalGuests);
                  }else if ($i==9) {
                     array_push($sepData, (int)$totalGuests);
                  }else if ($i==10) {
                     array_push($octData, (int)$totalGuests);
                  }else if ($i==11) {
                     array_push($novData, (int)$totalGuests);
                  }else if ($i==12) {
                     array_push($decData, (int)$totalGuests);
                  }

            }
            $dataArray[]=$result;

        }

            $chartdata=[$firstRow, $jandata, $febdata, $marchData, $aprData, $mayData, $juneData, $julyData, $augData, $sepData, $octData, $novData, $decData];
            $this->selectedDate=$this->selectedDate->toDateString();
            $this->channels=$dataArray;
            $this->chartdata=$chartdata;
            $this->dispatchBrowserEvent('guestChanged');
        return view('livewire.reports.b2b.guests-segmentation');
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
