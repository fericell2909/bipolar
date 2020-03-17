<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SaleSuccessful' => [
            'App\Listeners\SaleEmail',
            'App\Listeners\BsaleDocumentCreation',
        ],
        'App\Events\ProductSold' => [
            'App\Listeners\ProductCheckIfSoldOut',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
