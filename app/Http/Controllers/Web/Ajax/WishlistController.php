<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function add($productHashId)
    {
        $productToWishlist = Product::findByHash($productHashId);

        if (\Auth::check()) {
            $this->addWishlistIfAuth($productToWishlist);
        } else {
            $this->addWishlistIfGuest($productToWishlist);
        }

        return response()->json(['message' => 'Añadido a la lista de deseos']);
    }

    private function addWishlistIfAuth(Product $product)
    {
        return Wishlist::firstOrCreate([
            'user_id' => \Auth::id(),
            'product_id' => $product->id,
        ]);
    }

    private function addWishlistIfGuest(Product $product)
    {
        $existProduct = array_first(\Session::get('BIPOLAR_WISHLIST', []), function ($productInWishlist) use ($product) {
            return $productInWishlist->slug === $product->slug;
        });

        if (is_null($existProduct)) {
            \Session::push('BIPOLAR_WISHLIST', $product);
        }

        return;
    }
}
