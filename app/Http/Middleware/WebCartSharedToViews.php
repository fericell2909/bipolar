<?php

namespace App\Http\Middleware;

use App\Instances\CartBipolar;
use Closure;

class WebCartSharedToViews
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
        $cart = CartBipolar::getInstance();
        \View::share('bipolarCart', $cart);

        return $next($request);
    }
}
