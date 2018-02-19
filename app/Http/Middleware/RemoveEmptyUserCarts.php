<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Closure;

class RemoveEmptyUserCarts
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
        if (\Auth::check() === false) {
            return $next($request);
        }

        $carts = Cart::whereUserId(\Auth::id())->with('details')->get();

        $cartsWithoutDetails = $carts->filter(function ($cart) {
            return $cart->details->count() === 0;
        });
        $cartsWithDetails = $carts->filter(function ($cart) {
            return $cart->details->count() > 0;
        });

        if ($cartsWithoutDetails->count() === 1 && $cartsWithDetails->count() === 0) {
            return $next($request);
        }

        $cartsWithoutDetails->each(function (&$cart) {
            /** @var Cart $cart */
            return \DB::table('carts')->delete($cart->id);
        });

        return $next($request);
    }
}
