<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class WishlistController extends Controller
{
    public function remove($productSlug)
    {
        $productsWishlist = collect(\Session::get('BIPOLAR_WISHLIST', []))
            ->reject(function ($product) use ($productSlug) {
                return $product->slug === $productSlug;
            })
            ->values()
            ->all();

        \Session::put('BIPOLAR_WISHLIST', $productsWishlist);

        return redirect()->route('wishlist');
    }

    public function view()
    {
        if (empty(\Session::get('BIPOLAR_WISHLIST'))) {
            return redirect()->to('/');
        }

        return view('web.shop.wishlist');
    }
}
