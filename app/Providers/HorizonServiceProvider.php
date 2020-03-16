<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        if (config('logging.channels.slack.url')) {
            Horizon::routeSlackNotificationsTo(config('logging.channels.slack.url'), '#bipolar');
        }

        // Horizon::night();
    }

    /**
     * Register the Horizon gate.
     *
     * This gate determines who can access Horizon in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewHorizon', function ($user = null) {
            if (\Auth::guard('admin')->check()) {
                $auth = \Auth::guard('admin')->user();

                return in_array($auth->email, [
                    'info@helmerdavila.com',
                ]);
            }

            return false;

        });
    }
}
