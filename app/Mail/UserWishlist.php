<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;

class UserWishlist extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $wishlists;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $wishlists)
    {
        $this->wishlists = $wishlists;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
