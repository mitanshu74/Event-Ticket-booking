<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Admin;

class SubAdminPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subAdmin;
    public $password;

    public function __construct(Admin $subAdmin, $password)
    {
        $this->subAdmin = $subAdmin;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your SubAdmin Account Credentials')
            ->markdown('emails.subadmin_password');
    }
}
