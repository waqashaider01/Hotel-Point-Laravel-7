<?php

namespace App\Http\Livewire\Reports\Housekeeping;
use App\Models\Reservation;
use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use Livewire\Component;

class Daily extends Component
{
    public $date;
    // public collection $reservations;
    public $records;
    
    public function mount(){
        $this->date=today()->toDateString();
        
        
    }
    public function render()
    {
        $record=array();
        $date=$this->date;
        $reservations=Reservation::join('rooms', 'reservations.room_id', '=', 'rooms.id')
                                   ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
                                   ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                   ->where("arrival_date",'<=', $date)
                                   ->where("departure_date", ">=", $date)
                                    ->get(['reservations.id', 'arrival_date', 'departure_date', 'number', 'reservations.room_id', 'reference_code']);
        foreach($reservations as $reservation){
            $reservationid=$reservation['id'];
            $referenceCode=$reservation['reference_code'];
            $item=[];
            $comments=Comment::where('room_id',$reservation['room_id'] )->where('date', $this->date)->pluck('description')->first();
            if($reservation['arrival_date']==$this->date){
                $item['status']='Arrival';
                
            }else if($reservation['departure_date']==$this->date){
                $item['status']='Departure';
                
            }else{
                $item['status']='Accommodation';
                
            }
             $item['room']=$reservation['number']." (". $referenceCode.")";
             $item['comment']=$comments;
             $record[]=$item;
        }
        $this->records=$record;
        return view('livewire.reports.housekeeping.daily');
    }

    public function setdate($date){
        $this->date=$date;
        
    }
}
