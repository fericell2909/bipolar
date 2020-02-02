<?php

namespace App\Http\Middleware;

use Closure;

class LocalizationDetection
{
    private $currentSessionKey = 'BIPOLAR_ORIGIN_DETECTED_V4';

    /**
     * Set the currency and the language for the first time
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Crawler::isCrawler()) {
            \LaravelLocalization::setLocale('en');
            session(['BIPOLAR_CURRENCY' => 'USD']);
            return $next($request);
        }

        if ($request->session()->has($this->currentSessionKey)) {
            if (\Auth::check() && optional(\Auth::user())->language !== null) {
                return $next($request);
            } elseif (\Auth::guest()) {
                return $next($request);
            }
        }

        $latamAndSpain = ['AR', 'BO', 'BR', 'CO', 'CL', 'EC', 'GY', 'SR', 'UY', 'VE', 'ES'];

        $location = \IP2LocationLaravel::get($request->ip());

        if ($location['countryCode'] === 'PE') {
            session(['BIPOLAR_CURRENCY' => 'PEN']);
            \LaravelLocalization::setLocale('es');
            \Auth::check() ? \Auth::user()->fill(['language' => 'es'])->save() : null;
        } elseif (in_array($location['countryCode'], $latamAndSpain)) {
            session(['BIPOLAR_CURRENCY' => 'USD']);
            \LaravelLocalization::setLocale('es');
            \Auth::check() ? \Auth::user()->fill(['language' => 'es'])->save() : null;
        } else {
            session(['BIPOLAR_CURRENCY' => 'USD']);
            \LaravelLocalization::setLocale('en');
            \Auth::check() ? \Auth::user()->fill(['language' => 'en'])->save() : null;
        }

        session([$this->currentSessionKey => 1]);

        return $next($request);
    }
}
