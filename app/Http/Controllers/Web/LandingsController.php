<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\HomePost;
use App\Models\Settings;
use App\Models\Banner;
use Illuminate\Http\Request;

class LandingsController extends Controller
{
    public function home()
    {
        $homePosts = HomePost::whereStateId(config('constants.STATE_ACTIVE_ID'))
            ->with(['photos' => function ($withPhotos) {
                $withPhotos->orderBy('order');
            }, 'post_type'])
            ->orderBy('order')
            ->get();

        $settings = Settings::first();
        $banners = Banner::orderBy('order')
            ->where('begin_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        return view('welcome', compact('banners', 'homePosts', 'settings'));
    }

    public function changeCurrency(Request $request)
    {
        $this->validate($request, ['currency' => 'required|in:PEN,USD']);

        \Session::put('BIPOLAR_CURRENCY', $request->input('currency'));

        return redirect()->back();
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

    public function historico()
    {
        $contents = [];
        for ($number = 100; $number >= 1; $number--) {
            array_push($contents, [
                'number' => $number,
                'image' => 'http://fakeimg.pl/794x526',
            ]);
        }

        $inverse = false;

        return view('web.landings.historico', compact('contents', 'inverse'));
    }
}
