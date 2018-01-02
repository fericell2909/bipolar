<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\HomePost;
use App\Models\Product;
use App\Models\Settings;
use App\Models\Banner;

class LandingsController extends Controller
{
    public function home()
    {
        $homePosts = HomePost::whereStateId(config('constants.STATE_ACTIVE_ID'))
            ->with(['photos' => function ($withPhotos) {
                $withPhotos->orderBy('order');
            }])
            ->orderBy('order')
            ->get();

        $settings = Settings::first();
        $banners = Banner::orderBy('order')->get();

        return view('welcome', compact('banners', 'homePosts', 'settings'));
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
