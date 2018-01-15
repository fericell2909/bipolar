<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class WishlistController extends Controller
{
    public function add($productSlug)
    {
        $productToWishlist = Product::findBySlugOrFail($productSlug);

        $existProduct = array_first(\Session::get('BIPOLAR_WISHLIST', []), function ($product) use ($productToWishlist) {
            return $product->slug === $productToWishlist->slug;
        });

        if (is_null($existProduct)) {
            \Session::push('BIPOLAR_WISHLIST', $productToWishlist);
        }

        return redirect()->route('wishlist');
    }

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
