<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\HomePost;
use App\Models\Product;
use App\Models\Settings;

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

        return view('welcome', compact('homePosts', 'settings'));
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
