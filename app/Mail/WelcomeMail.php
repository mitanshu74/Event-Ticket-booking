<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $username;
    public $otp;

    public function __construct($username, $otp)
    {
        $this->username = $username;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Welcome to Our Platform - Your OTP')
            ->view('emails.welcome'); // Blade view
    }
}
