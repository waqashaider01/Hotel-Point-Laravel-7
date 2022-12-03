<?php

namespace App\Http\Livewire\Reports\B2b;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Livewire\Component;

class Commission extends Component
{
    public $startDate;
    public $endDate;
    public $chartdata;
    public $statistics;

    public function mount(){
        $currenDate=today();
        $nextDate=$currenDate->copy()->addDays(30);
        $this->startDate=$currenDate->toDateString();
        $this->endDate=$nextDate->toDateString();
    }

    public function setValues($start, $end){
        $this->startDate=$start;
        $this->endDate=$end;
    }

    public function render()
    {
        $chartdata=[['Booking Agency', 'Market Commission'], ['', 0]];
        $statistics=[];
        $startDate=$this->startDate;
        $endDate=$this->endDate;

        $bookingAgencies=Reservation::join('booking_agencies', 'reservations.booking_agency_id', '=', 'booking_agencies.id')->where('booking_agencies.hotel_settings_id', getHotelSettings()->id)->where('booking_agencies.name', '!=', 'Individual')->whereBetween('check_out', [$startDate, $endDate])->groupBy('booking_agency_id', 'booking_agencies.name')->get(['reservations.booking_agency_id', 'booking_agencies.name']);
        foreach ($bookingAgencies as $agency) {
               $agencyName=$agency['name'];
               $reservationAmount=0;
               $commissionAmount=0;
               $getData=Reservation::selectRaw('sum(reservation_amount) as reservationSum, sum(commission_amount) as commissionSum')->where('booking_agency_id', $agency->booking_agency_id)->whereBetween('check_out', [$startDate, $endDate])->get();
               if ($getData->isEmpty()) {
                  
               }else{
                  $getData=$getData[0];
                  $reservationAmount=$getData['reservationSum'];
                  $commissionAmount=$getData['commissionSum'];
               }

               if ($reservationAmount==0 || $commissionAmount==0) {
                   $commissionPercent=0;
               }else{
                   $commissionPercent=(float)$commissionAmount/(float)$reservationAmount*100;
               }
               $commissionPercent=number_format((float)$commissionPercent, 2, '.', '');
               $reservationAmount1=showPriceWithCurrency($reservationAmount);
               $commissionAmount1=showPriceWithCurrency($commissionAmount);
               array_push($statistics, [$agencyName, $reservationAmount1, $commissionAmount1, $commissionPercent]);
               array_push($chartdata, [$agencyName, array('v'=>(float)$commissionAmount, 'f'=>$commissionAmount1)]);
        }
        array_push($chartdata, ['', 0]);
        $this->statistics=$statistics;
        $this->chartdata=$chartdata;
        $this->dispatchBrowserEvent('commissionChanged');
        return view('livewire.reports.b2b.commission');
    }
}
