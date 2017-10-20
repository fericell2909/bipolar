<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Type;

class ShopController extends Controller
{
    public function shop()
    {
        $products = Product::whereNotNull('active')->with('photos')->paginate(12);
        $types = Type::with(['subtypes', 'subtypes.products'])->get();

        return view('web.shop', compact('countProducts','products', 'types'));
    }
}