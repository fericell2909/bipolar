<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminChangedPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $email;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $date)
    {
        $this->email = $email;
        $this->date = $date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Se ha cambiado tu contraseña')->markdown('emails.admin_changed_password');
    }
}
