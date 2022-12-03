<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\Reservation;
use App\Models\Comment;
use Carbon\Carbon;

use Livewire\Component;

class DailyBreakfast extends Component
{
    public $selectedDate;
    public $breakfasts;

    public function mount(){
        $this->selectedDate=today()->toDateString();
    }
    public function render()
    {
        $dataArray=[];
        $getBreakfasts=Reservation::join('rate_types', 'reservations.rate_type_id', '=', 'rate_types.id')
                                    ->join('rate_type_categories', 'rate_type_categories.id', '=', 'rate_type_category_id')
                                    ->join('rooms', 'rooms.id', '=', 'reservations.room_id')
                                    ->join('room_types', 'room_types.id', '=', 'rooms.room_type_id')
                                    ->where('reservations.hotel_settings_id', getHotelSettings()->id)
                                    ->where('has_breakfast', 1)
                                    ->where('arrival_date', '<', $this->selectedDate)
                                    ->where('departure_date', '>=', $this->selectedDate)
                                    ->whereNotIn('reservations.status', ['Cancelled', 'No Show'])
                                    ->where('type_status', 1)
                                    ->where('rooms.status', 'Enabled')
                                    ->get();
        foreach ($getBreakfasts as $breakfast) {
            $breakfastComment='<ul>';
            $comments=Comment::where('room_id', $breakfast['room_id'])->where('type', 'fb')->get();
            foreach ($comments as $comment) {
                if ($comment->description) {
                    $breakfastComment.="<li>".$comment->description."</li>";
                }
             
            }
            if ($breakfast['comment']) {
                $breakfastComment.= "<li>". $breakfast['comment']."</li>";
            }
            $breakfastComment.="</ul>";
               array_push($dataArray, [$breakfast['number'], $breakfast['adults'], $breakfast['kids'], $breakfast['infants'], $breakfastComment]);
        }

        $this->breakfasts=$dataArray;
                                    
        return view('livewire.reports.roomdivision.daily-breakfast');
    }

    public function setdate($date){
        $this->selectedDate= Carbon::parse($date)->toDateString();
      }
}
