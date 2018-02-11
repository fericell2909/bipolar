<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;

class WishlistController extends Controller
{
    public function add($productHashId)
    {
        $productToWishlist = Product::findByHash($productHashId);

        $existProduct = array_first(\Session::get('BIPOLAR_WISHLIST', []), function ($product) use ($productToWishlist) {
            return $product->slug === $productToWishlist->slug;
        });

        if (is_null($existProduct)) {
            \Session::push('BIPOLAR_WISHLIST', $productToWishlist);
        }

        return response()->json(['message' => 'Añadido a la lista de deseos']);
    }
}
