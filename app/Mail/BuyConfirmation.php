<?php

namespace App\Mail;

use App\Models\Buy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BuyConfirmation extends Mailable
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
        return $this->subject(__('bipolar.mails.buy_received_subject'))->view('emails.web_buy_confirmation');
    }
}
