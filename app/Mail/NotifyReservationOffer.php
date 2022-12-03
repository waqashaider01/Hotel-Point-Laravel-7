<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyReservationOffer extends Mailable
{
    use Queueable, SerializesModels;


    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $email =  $this->subject('Special Booking Offer')
            ->from(getHotelSettings()->email, getHotelSettings()->name)
            ->view('emails.notify-reservation-offer');
        return $email;
    }
}
