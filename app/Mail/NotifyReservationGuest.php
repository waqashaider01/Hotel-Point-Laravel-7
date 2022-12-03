<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyReservationGuest extends Mailable
{
    use Queueable, SerializesModels;


    public $subject;
    public $email_body;
    public $files;

    public function __construct($subject, $email_body, $attachments)
    {
        $this->subject = $subject;
        $this->email_body = $email_body;
        $this->files = $attachments;
    }

    public function build()
    {
        $email =  $this->subject($this->subject)
            ->from(getHotelSettings()->email, getHotelSettings()->name)
            ->view('emails.notify-reservation-guest');
        foreach ($this->files as $attachment){
            $email->attachFromStorage($attachment);
        }
        return $email;
    }
}
