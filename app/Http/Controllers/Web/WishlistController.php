<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function view()
    {
        $wishlists = [];
        if (\Auth::check()) {
            if (\Auth::user()->wishlists->count() === 0) {
                return redirect()->to('/');
            }

            $wishlists = Wishlist::whereUserId(\Auth::id())->with('product.photos')->get();
        }

        if (empty(\Session::get('BIPOLAR_WISHLIST'))) {
            return redirect()->to('/');
        }

        return view('web.shop.wishlist', compact('wishlists'));
    }

    public function remove($productSlug)
    {
        if (\Auth::check()) {
            $this->removeIfAuth($productSlug);
        } else {
            $this->removeIfGuest($productSlug);
        }

        return redirect()->route('wishlist');
    }

    private function removeIfAuth($productSlug)
    {
        $wishlists = \Auth::user()->wishlists;

        $wishlists->each(function ($wishlist) use ($productSlug) {
            if ($wishlist->product->slug === $productSlug) {
                $wishlist->delete();
            }
        });
    }

    private function removeIfGuest($productSlug)
    {
        $productsWishlist = collect(\Session::get('BIPOLAR_WISHLIST', []))
            ->reject(function ($product) use ($productSlug) {
                return $product->slug === $productSlug;
            })
            ->values()
            ->all();

        \Session::put('BIPOLAR_WISHLIST', $productsWishlist);
    }
}
