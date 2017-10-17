<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class LandingsController extends Controller
{
    public function shipping()
    {
        return view('web.landings.shipping');
    }
}
