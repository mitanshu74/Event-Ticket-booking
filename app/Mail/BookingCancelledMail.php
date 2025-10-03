<?php

namespace App\Mail;

use App\Models\booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Booking Cancelled')
            ->view('emails.booking-cancelled');
    }
}
