<?php

namespace App\Listeners;

use App\Events\SaleSuccessful;
use App\Mail\BuyConfirmation;
use App\Models\Buy;

class SaleEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  SaleSuccessful  $event
     * @return void
     */
    public function handle(SaleSuccessful $event)
    {
        \Mail::to($event->buy->user->email)->send(new BuyConfirmation($event->buy));
    }
}
