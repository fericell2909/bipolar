<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannersController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();

        return view('admin.banners.index', compact('banners'));
    }
}
