<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $user_name;

    public function __construct($url,$user_name)
    {
        $this->url = $url;
        $this->user_name = $user_name;
    }

    public function build()
    {
        return $this->subject('Verification of Forget Password By HotelPoint Team')
            ->view('emails.reset-password');
    }
}
