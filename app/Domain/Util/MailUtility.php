<?php
namespace App\Domain\Util;

use Illuminate\Support\Facades\Mail;

class MailUtility
{
    public function sendMail($view, $data, $toEmail, $subject)
    {
    	
        Mail::send($view, $data, function ($message) use($toEmail, $subject) {
            $message->to($toEmail);
            $message->subject($subject);
        });
    }
}
