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
        if ($request->session()->has('BIPOLAR_ORIGIN_DETECTED_V2')) {
            return $next($request);
        }

        $latamAndSpain = ['AR', 'BO', 'BR', 'CO', 'CL', 'EC', 'GY', 'SR', 'UY', 'VE', 'ES'];

        $location = geoip()->getLocation($request->ip());

        session(['BIPOLAR_CURRENCY' => 'USD']);
        \LaravelLocalization::setLocale('en');

        if ($location['country_code2'] === 'PE') {
            session(['BIPOLAR_CURRENCY' => 'PEN']);
            \LaravelLocalization::setLocale('es');
        }

        if (in_array($location['country_code2'], $latamAndSpain)) {
            \LaravelLocalization::setLocale('es');
        }

        session(['BIPOLAR_ORIGIN_DETECTED_V2' => 1]);

        return $next($request);
    }
}
