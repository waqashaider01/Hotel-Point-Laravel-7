<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Country;
use App\Models\Guest;

class NotifyReceiveReservation extends Mailable
{
    use Queueable, SerializesModels;
    public $title;
    public $hotel;
    public $agencyname;
    public $bookingCode;
    public $lastupdate;
    public $totalAmount;
    public $pax;
    public $name;
    public $zip;
    public $countryName;
    public $city;
    public $phone;
    public $email;
    public $address;
    public $roomtypeString;
    public $guestInfo;
    public $commission;
    public $rateLevel;
    public $status='';


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reservation, $hotel, $rateLevel, $guestInfo, $roomtypeString, $pax)
    {
        
        $guest=Guest::where('id', $reservation->guest_id)->first();
        $country=Country::where('id', $reservation->country_id)->first();
        $this->rateLevel=$rateLevel;
        $this->guestInfo=$guestInfo;
        $this->roomtypeString=$roomtypeString;
        $this->pax=$pax;
        $this->status=$reservation->channex_status;
        if ($reservation->channex_status=="new") {
            $this->title="<div style='background:green; color:white; padding:10px 0px; font-size:20px; '><center>New Reservation </center></div>";
        }elseif ($reservation->channex_status=="modified") {
            $this->title="<div style='background:purple; color:white; padding:10px 0px; font-size:20px; '><center>Modified Reservation </center></div>";
        }elseif ($reservation->channex_status=="cancelled") {
            $this->title="<div style='background:#DC143C; color:white; padding:10px 0px; font-size:20px; '><center>Cancelled Reservation </center></div>";
        }else{}
        
        $this->hotel=$hotel;
        $this->agencyname=$reservation->booking_agency->name;
        $this->bookingCode=$reservation->booking_code;
        $this->lastupdate=$reservation->reservation_inserted_at;
        $this->totalAmount=formatCurrency($reservation->reservation_amount, $hotel);
        $this->pax=$pax;
        $this->name=$reservation->guest->full_name;
        $this->zip=$reservation->guest->zip;
        $this->countryName=$country->name;
        $this->city=$reservation->guest->city;
        $this->phone=$reservation->guest->phone;
        $this->email=$reservation->guest->email;
        $this->address=$reservation->guest->address;

        $this->commission=formatCurrency($reservation->commission_amount, $hotel);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject=ucwords($this->status)." Reservation";
        $email =  $this->subject($subject)
            ->from('bookings@hotelpoint.gr')
            ->view('emails.notify-receive-reservation');
        
        return $email;
    }
}
