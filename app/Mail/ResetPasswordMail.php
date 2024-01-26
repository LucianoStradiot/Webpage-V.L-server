<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;
    public $resetLink;


    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;

    }

    public function build()
    {

        return $this->subject("Reestablecimiento de contraseña")
            ->view('emails.reset-password');
    }
}
