<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Size;
use App\Models\Type;

class ShopController extends Controller
{
    public function shop()
    {
        $products = Product::whereNotNull('active')->with('photos')->paginate(12);
        $types = Type::with(['subtypes', 'subtypes.products'])->get();
        $sizes = Size::orderBy('name')->get();

        return view('web.shop.shop', compact('countProducts','products', 'types', 'sizes'));
    }

    public function product($slugProduct)
    {
        /** @var Product $product */
        $product = Product::findBySlugOrFail($slugProduct);

        return view('web.shop.product', compact('product'));
    }
}