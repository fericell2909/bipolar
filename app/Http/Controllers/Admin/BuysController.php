<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buy;

class BuysController extends Controller
{
    public function index()
    {
        $buys = Buy::orderByDesc('id')
            ->with(['user', 'details.product', 'shipping_address.country_state.country'])
            ->get();

        return view('admin.buys.index', compact('buys'));
    }
}
