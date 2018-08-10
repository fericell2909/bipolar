<?php

namespace App\Http\Middleware;

use Closure;

class LocalizationDetection
{
    /**
     * Set the currency and the language for the first time
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('BIPOLAR_ORIGIN_DETECTED')) {
            return $next($request);
        }

        $latamAndSpain = ['AR', 'BO', 'BR', 'CO', 'CL', 'EC', 'GY', 'SR', 'UY', 'VE', 'ES'];

        $location = geoip()->getLocation($request->ip());

        session(['BIPOLAR_CURRENCY' => 'USD']);
        \LaravelLocalization::setLocale('en');

        if ($location['iso_code'] === 'PE') {
            session(['BIPOLAR_CURRENCY' => 'PEN']);
            \LaravelLocalization::setLocale('es');
        }

        if (in_array($location['iso_code'], $latamAndSpain)) {
            \LaravelLocalization::setLocale('es');
        }

        session(['BIPOLAR_ORIGIN_DETECTED' => 1]);

        return $next($request);
    }
}
