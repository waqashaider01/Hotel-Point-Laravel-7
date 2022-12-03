<?php

namespace App\Http\Livewire\Reports\Revenue;
use App\Models\Country;
use App\Models\Reservation;
use App\Models\DailyRate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use Livewire\Component;

class Market extends Component
{
    public $mode='current';
    public  $chartdata;
    public $year;
    public $guests;
    public collection $countries;
   
    public function mount(){
      $this->year=today()->year;
      
    }

    public function render()
    {
        
        $this->createData();
        $this->dispatchBrowserEvent('marketChanged');
        return view('livewire.reports.revenue.market');
    }

   
 
     public function setyear($year){
       $this->year=$year;
    }

    public function createData(){
        $startyear=$this->year."-01-01";
        $endyear=$this->year."-12-31";
        $chart=[['Country', 'Market Revenue'],['', 0]];
        $dataArray=[];
        $hotelId=getHotelSettings()->id;
        $countries=DB::select("SELECT countries.id, countries.name, countries.alpha_two_code FROM `availabilities`
                                    INNER JOIN `reservations` ON availabilities.reservation_id=reservations.id
                                    INNER JOIN `countries` ON reservations.country_id=countries.id
                                    INNER JOIN `rooms` ON reservations.room_id=rooms.id
                                    INNER JOIN `room_types` ON rooms.room_type_id=room_types.id
                                    WHERE availabilities.date BETWEEN '$startyear' AND '$endyear'
                                    AND reservations.hotel_settings_id='$hotelId'
                                    AND(reservations.status!='Cancelled' OR reservations.channex_status!='cancelled')
                                    AND rooms.status='Enabled' AND room_types.type_status='1'
                                    GROUP BY countries.name, countries.alpha_two_code, countries.id");
        
              foreach($countries as $country){
                  $countryid=$country->id;
                  $countryName=$country->name;
                  $countrycode=$country->alpha_two_code;
                  $data=array();
                  $data['code']=$countrycode;
                  $data['name']=$countryName;
                  $chartitem=[$countryName];
                  $totalRevenue=0;

                  for ($i=1; $i <=12 ; $i++) { 
                     $startDate=$this->year.'-'.$i."-01";
                     $startDate=Carbon::parse($startDate)->toDateString();
                     $endDate=Carbon::parse($startDate)->endOfMonth();
                     $marketSum=Reservation::join('daily_rates', 'reservations.id', '=', 'daily_rates.reservation_id')
                                             ->join('countries', 'countries.id', '=', 'reservations.country_id')
                                             ->join('rooms', 'reservations.room_id', '=', 'rooms.id')
                                             ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
                                             ->whereBetween('daily_rates.date', [$startDate, $endDate])
                                             ->where('countries.id', $countryid)
                                             ->where('reservations.hotel_settings_id', $hotelId)
                                             ->where('reservations.status', '!=', 'Cancelled')
                                             ->where('reservations.channex_status', '!=', 'cancelled')
                                             ->where('rooms.status','Enabled')
                                             ->where('room_types.type_status', 1)
                                             ->sum('daily_rates.price');
                     $data[$i]=showPriceWithCurrency($marketSum);
                     $totalRevenue+=(float)$marketSum;
                       

                  }
                  $dataArray[]=$data;
                  array_push($chartitem, array("v"=>(float)$totalRevenue, "f"=>showPriceWithCurrency($totalRevenue)));
                  $chart[]=$chartitem;
                  
              }
              $chart[]=['', 0];
              $this->guests=$dataArray;
              $this->chartdata=$chart;
            
   }
}
