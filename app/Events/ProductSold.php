<?php

namespace App\Events;

use App\Models\Buy;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ProductSold
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
