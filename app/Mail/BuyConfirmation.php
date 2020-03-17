<?php

namespace App\Mail;

use App\Models\Buy;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BuyConfirmation extends Mailable implements ShouldQueue
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
        $shippingMethod = $this->buy->showroom ? __('bipolar.mails.shipping_method_showroom') : optional($this->buy->shipping)->title;

        $subjectConfirmation = config('app.env') !== 'production' ? '[BETA] ' . __('bipolar.mails.buy_received_subject') : __('bipolar.mails.buy_received_subject');

        return $this->cc('shop@bipolar.com.pe')
            ->subject($subjectConfirmation)
            ->view('emails.web_buy_confirmation')
            ->with('shipping_method',  $shippingMethod);
    }
}
