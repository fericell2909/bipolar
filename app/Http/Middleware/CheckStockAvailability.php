<?php

namespace App\Http\Middleware;

use Closure;

class CheckStockAvailability
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var \App\Models\Cart $cart */
        $cart = \CartBipolar::model();

        if (empty($cart)) {
            return redirect(route('shop'));
        }

        if ($cart->details->count() === 0) {
            return redirect(route('shop'));
        }

        $productsWithEmptyStocks = $cart->details->filter(function ($detail) {
            /** @var \App\Models\CartDetail $detail */
            return $detail->stock->quantity === 0;
        });

        if ($productsWithEmptyStocks->isEmpty()) {
            return $next($request);
        }

        $detailsWithoutStock = $productsWithEmptyStocks->map(function ($detail) {
            /** @var \App\Models\CartDetail $detail */
            $productName = $detail->product->name;

            if ($detail->stock->size) {
                $productName = "{$productName} " . mb_strtolower(__('bipolar.size_abbr')) . " {$detail->stock->size->name}";
            }

            if ($detail->product->colors->count()) {
                $colors = $detail->product->colors->implode('name', ',');
                $productName .= " {$colors}";
            }

            return [
                'message'      => __('bipolar.cart.delete_item', ['name' => $productName]),
                'product_slug' => $detail->product->slug,
            ];
        })->toArray();

        session()->flash('details_without_stock', $detailsWithoutStock);

        return redirect(route('cart'));
    }
}
