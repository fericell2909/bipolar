<?php

namespace App\Http\Middleware;

use Closure;

class LocalizationDetection
{
    /**
     * Set the currency and the language for the first time
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->session()->has('BIPOLAR_ORIGIN_DETECTED_V3')) {
            return $next($request);
        }

        $latamAndSpain = ['AR', 'BO', 'BR', 'CO', 'CL', 'EC', 'GY', 'SR', 'UY', 'VE', 'ES'];

        $location = geoip()->getLocation($request->ip());

        if ($location['country_code2'] === 'PE') {
            session(['BIPOLAR_CURRENCY' => 'PEN']);
            \LaravelLocalization::setLocale('es');
            \Auth::check() ? \Auth::user()->fill(['language' => 'es'])->save() : null;
        } elseif (in_array($location['country_code2'], $latamAndSpain)) {
            session(['BIPOLAR_CURRENCY' => 'USD']);
            \LaravelLocalization::setLocale('es');
            \Auth::check() ? \Auth::user()->fill(['language' => 'es'])->save() : null;
        } else {
            session(['BIPOLAR_CURRENCY' => 'USD']);
            \LaravelLocalization::setLocale('en');
            \Auth::check() ? \Auth::user()->fill(['language' => 'en'])->save() : null;
        }

        session(['BIPOLAR_ORIGIN_DETECTED_V3' => 1]);

        return $next($request);
    }
}
