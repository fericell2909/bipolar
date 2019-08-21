<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BsaleController extends Controller
{
    public function sync(Request $request)
    {
        \Log::info('BSALE: Stock updated', $request->all());
    }
}