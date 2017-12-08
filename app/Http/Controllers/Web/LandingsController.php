<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Settings;

class LandingsController extends Controller
{
    public function home()
    {
        $productsInHome = Product::with([
            'photos' => function ($withPhotos) {
                $withPhotos->orderBy('order');
            }, 'colors'
        ])
            ->orderBy('name')
            ->get();

        $settings = Settings::first();

        return view('welcome', compact('productsInHome', 'settings'));
    }

    public function bipolar()
    {
        return view('web.landings.bipolar');
    }

    public function shipping()
    {
        return view('web.landings.shipping');
    }

    public function showroom()
    {
        return view('web.landings.showroom');
    }
}
