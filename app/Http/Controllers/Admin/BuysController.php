<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Buy;

class BuysController extends Controller
{
    public function index()
    {
        $buys = Buy::orderByDesc('id')
            ->with(['user', 'details', 'shipping_address.country_state.country'])
            ->get();

        return view('admin.buys.index', compact('buys'));
    }
}
