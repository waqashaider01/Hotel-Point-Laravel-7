<?php

namespace App\Http\Livewire\Reports\Roomdivision;
use App\Models\HotelSetting;
use App\Models\Reservation;
use App\Models\Availability;
use App\Models\GuestAccommodationPayment;
use App\Models\ReservationExtraCharge;
use App\Models\GuestExtrasPayment;
use App\Models\Comment;
use Carbon\Carbon;

use Livewire\Component;

class Departures extends Component
{
    public $selectedDate;
    public $departures;
    public $overnightTax;

    public function mount(){
        $this->selectedDate=today()->toDateString();
        $this->overnightTax=getHotelSettings()->overnight_tax->tax;
    }
    public function render()
    {
        $departures=[];
        $reservations=Reservation::join('rooms', 'rooms.id', '=', 'reservations.room_id')->join('guests', 'reservations.guest_id', '=', 'guests.id')->where('reservations.hotel_settings_id', getHotelSettings()->id)->where('departure_date', $this->selectedDate)->get(['reservations.id', 'reservations.room_id', 'number', 'full_name', 'reservations.comment', 'reservation_amount' ]);
        foreach ($reservations as $reservation) {
             $nights=$reservation->availabilities->count();
             $reservationAccommodation=$reservation->reservation_amount;
           
             $overnightTaxAmount=(int)$nights*(float)$this->overnightTax;
             $overnightTaxAmount=showPriceWithCurrency($overnightTaxAmount);

             $accomodationPayments=GuestAccommodationPayment::where('reservation_id', $reservation['id'])->sum('value');
             $extrasPayments=GuestExtrasPayment::where('reservation_id', $reservation['id'])->sum('value');
             $extraCharges=ReservationExtraCharge::where('reservation_id', $reservation['id'])->sum('extra_charge_total');
  
             $totalamount=(float)$reservationAccommodation+(float)$extraCharges;
             $totalPaid=(float)$accomodationPayments+(float)$extrasPayments;
             $amountToBePaid=(float)$totalamount-(float)$totalPaid;
             $amountToBePaid=showPriceWithCurrency($amountToBePaid);
           
             $departureComment='<ul>';
             $comments=Comment::where('room_id', $reservation['room_id'])->whereIn('type', ['fd', 'hk'])->get();
             foreach ($comments as $comment) {
                if ($comment->description) {
                    $departureComment.="<li>".$comment->description."</li>";
                }
              
             }
             if ($reservation['comment']) {
                $departureComment.= "<li>". $reservation['comment']."</li>";
             }
             $departureComment.="</ul>";
             
             array_push($departures, [$reservation['number'], $reservation['full_name'], $amountToBePaid, $overnightTaxAmount, $departureComment ]);


        }
        $this->departures=$departures;
        return view('livewire.reports.roomdivision.departures');
    }

    public function setdate($date){
        $this->selectedDate= Carbon::parse($date)->toDateString();
      }
}
