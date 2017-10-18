<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function shop()
    {
        return view('web.shop');
    }
}