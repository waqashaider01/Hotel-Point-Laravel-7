<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\Availability;
use Carbon\Carbon;

use Livewire\Component;

class Guests extends Component
{
    public $chartdata;
    public $adults;
    public $kids;
    public $infants;
    public $selectedDate;
    public $year;
    public $mode;

    public function mount(){
        $this->selectedDate=today();
        $this->mode="current";
    }
    public function render()
    {
        $this->year=$this->selectedDate->year;
        $cdate=$this->selectedDate->day;
        $adultsArray=[];
        $kidsArray=[];
        $infantsArray=[];
        $chartdata=[['Months', 'Adults', 'Kids', 'Infants']];
        for ($i=1; $i <=12 ; $i++) { 
            $startDate=$this->year.'-'.$i."-01";
            $startDate=Carbon::parse($startDate)->toDateString();
            if ($this->mode=="current") {
                $endDate=$this->year."-".$i."-".$cdate;
                $endDate=Carbon::parse($endDate)->toDateString();
            }else{
                $endDate=Carbon::parse($startDate)->endOfMonth();
            }

            $getGuests=Availability::join('reservations', 'reservations.id', '=', 'availabilities.reservation_id')
                                    ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                    ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                    ->selectRaw('sum(adults) as totalAdults, sum(kids) as totalKids, sum(infants) as totalInfants ')
                                    ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                    ->whereBetween('date',[$startDate, $endDate])
                                    ->where(function($query){
                                        $query->where('reservations.status','!=', 'Cancelled')
                                              ->orWhere('reservations.channex_status','!=', 'cancelled');
                                    })
                                    ->where('type_status', 1)
                                    ->where('rooms.status', 'Enabled')
                                    ->get();
            $getGuests=$getGuests[0];
            $adults=(int)$getGuests['totalAdults'];
            $kids=(int)$getGuests['totalKids'];
            $infants=(int)$getGuests['totalInfants'];
            array_push($adultsArray, $adults);
            array_push($kidsArray, $kids);
            array_push($infantsArray, $infants);
            if ($i==1) {
                array_push($chartdata, ['Jan', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==2) {
                array_push($chartdata, ['Feb', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==3) {
                array_push($chartdata, ['Mar', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==4) {
                array_push($chartdata, ['Apr', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==5) {
                array_push($chartdata, ['May', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==6) {
                array_push($chartdata, ['Jun', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==7) {
                array_push($chartdata, ['Jul', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==8) {
                array_push($chartdata, ['Aug', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==9) {
                array_push($chartdata, ['Sep', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==10) {
                array_push($chartdata, ['Oct', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==11) {
                array_push($chartdata, ['Nov', (int)$adults, (int)$kids, (int)$infants]);
            }else if ($i==12) {
                array_push($chartdata, ['Dec', (int)$adults, (int)$kids, (int)$infants]);
            }else{}

                                
                                    

        }

        $this->adults=$adultsArray;
        $this->kids=$kidsArray;
        $this->infants=$infantsArray;
        $this->chartdata=$chartdata;
        $this->selectedDate=$this->selectedDate->toDateString();
        $this->dispatchBrowserEvent('guestsChanged');
        
        return view('livewire.reports.roomdivision.guests');
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
