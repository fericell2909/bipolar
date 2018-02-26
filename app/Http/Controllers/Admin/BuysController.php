<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buy;

class BuysController extends Controller
{
    public function index()
    {
        $buys = Buy::orderByDesc('id')
            ->with(['user', 'details.product', 'details.buy', 'shipping_address.country_state.country', 'payments'])
            ->paginate(20);

        return view('admin.buys.index', compact('buys'));
    }
}
