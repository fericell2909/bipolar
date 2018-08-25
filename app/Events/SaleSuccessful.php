<?php

namespace App\Events;

use App\Models\Buy;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class SaleSuccessful
{
    use Dispatchable, SerializesModels;

    public $buy;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Buy $buy)
    {
        $this->buy = $buy;
    }
}
