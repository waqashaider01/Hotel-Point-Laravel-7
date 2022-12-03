<?php

namespace App\Http\Livewire\Reports\Housekeeping;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Livewire\Component;

class Yearly extends Component
{
    public $fromDate;
    public $toDate;
    public $monthlyRecords;
    public $totalArrival;
    public $totalDeparture;
    public $totalAccomodated;
    public $totalOutOfOrder;
    public $startDate;
    public $endDate;

    public function mount(){
        $now=Carbon::now();
        $this->startDate=$now->copy()->format('Y-m-d');
        $this->endDate=$now->copy()->addDays(30)->format('Y-m-d');

    }

    public function render()
    {
        $startDate=$this->startDate;
        $endDate=$this->endDate;
        $totalAccomodated=0;
        $totalArrival=0;
        $totalDeparture=0;
        $totalOutOfOrder=0;
        $roomstat=[];
        $rooms=Room::join('room_types', 'rooms.room_type_id', '=', 'room_types.id')->where('room_types.hotel_settings_id', getHotelSettings()->id)->where('status','Enabled')->where('type_status',1)->get(['rooms.id', 'number', 'reference_code']);
        foreach($rooms as $room){
            
            $roomid=$room['id'];
            $roomnumber=$room['number'];
            $referenceCode=$room['reference_code'];
            $roomArrival=0;
            $roomDeparture=0;
            $roomAccomodated=0;
            $roomOutofOrder=0;
            $stats=Reservation::where('room_id', $roomid)
                                ->where(function($query) use($startDate, $endDate){
                                    $query->whereBetween('arrival_date', [$startDate, $endDate])
                                          ->orWhereBetween('departure_date', [$startDate, $endDate]);
                                })
                                
                                ->get(['arrival_date', 'departure_date', 'id', 'room_id']);
            foreach($stats as $stat){
                $checkin=$stat['arrival_date'];
                $checkout=$stat['departure_date'];
                if ($checkin>=$startDate && $checkin<=$endDate) {
                    $roomArrival++;
                    $totalArrival++;
                }
                if ($checkout>=$startDate && $checkout<=$endDate) {
                    $roomDeparture++;
                    $totalDeparture++;
                }
                    if ($checkin<$startDate) {
                        $checkin=$startDate;
                    }
                    if ($checkout>$endDate) {
                        $checkout=$endDate;
                    }
                    $checkin=Carbon::parse($checkin)->addDay()->setTime(0,0);
                    $checkout=Carbon::parse($checkout)->setTime(0,0);
                    $nights=$checkin->diff($checkout)->format("%a");
                    $roomAccomodated+=(int)$nights;
                    $totalAccomodated+=(int)$nights;

                
                
            }

            $maintenance=Maintenance::where('room_id', $roomid)
                                      ->where(function($query) use($startDate,$endDate){
                                        $query->whereBetween('start_date', [$startDate, $endDate])
                                              ->orWhereBetween('end_date', [$startDate, $endDate]);
                                      })->get();
            foreach($maintenance as $row){
                  $start=$row['start_date'];
                  $end=$row['end_date'];
                  if ($start<$startDate) {
                      $start=$startDate;
                  }
                  if ($end>$endDate) {
                      $end=$endDate;
                  }
                  $start=Carbon::parse($start)->setTime(0,0);
                  $end=Carbon::parse($end)->setTime(0,0);
                  $countOutOfOrder=$start->diff($end)->format("%a");
                  $roomOutofOrder=(int)$countOutOfOrder+1;
                  $totalOutOfOrder+=$roomOutofOrder;

            }

            $item=[];
            $item['room']=$roomnumber." (".$referenceCode.")";
            $item['accommodated']=$roomAccomodated;
            $item['arrival']=$roomArrival;
            $item['departure']=$roomDeparture;
            $item['outOfOrder']=$roomOutofOrder;
            $roomstat[]=$item;


        }
        $this->totalArrival=$totalArrival;
        $this->totalAccomodated=$totalAccomodated;
        $this->totalDeparture=$totalDeparture;
        $this->totalOutOfOrder=$totalOutOfOrder;
        $this->monthlyRecords=$roomstat;
        $this->dispatchBrowserEvent('yearlyChanged');
        return view('livewire.reports.housekeeping.yearly');
    }

    public function setdate($from, $to){
        $this->startDate=$from;
        $this->endDate=$to;
    }
}
