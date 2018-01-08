<?php

namespace App\Http\Middleware;

use Closure;

class SetShopCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Session::has('BIPOLAR_CURRENCY') === false) {
            \Session::put('BIPOLAR_CURRENCY', 'PEN');
        }

        return $next($request);
    }
}
