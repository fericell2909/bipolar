<?php

namespace App\Mail;

use App\Models\Buy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BuySent extends Mailable implements ShouldQueue
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
        return $this
            ->cc('shop@bipolar.com.pe')
            ->subject(__('bipolar.mails.title_order_sent'))
            ->view('emails.admin_buy_sent');
    }
}
