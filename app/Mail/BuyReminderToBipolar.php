<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Buy;

class BuyReminderToBipolar extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $buy;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Buy $buy)
    {
        $this->buy = $buy;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(bipolar_mail_subject_env_header('Recordatorio: Compra por marcar'))
            ->markdown('emails.admin_buy_reminder');
    }
}
