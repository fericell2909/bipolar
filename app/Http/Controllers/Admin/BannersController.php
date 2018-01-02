<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\State;

class BannersController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->with('state')->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.banners.new', compact('states'));
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
