<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class LandingsController extends Controller
{
    public function bipolar()
    {
        return view('web.landings.bipolar');
    }

    public function shipping()
    {
        return view('web.landings.shipping');
    }
}
