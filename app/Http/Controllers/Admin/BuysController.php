<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buy;

class BuysController extends Controller
{
    public function index()
    {
        $buys = Buy::orderByDesc('id')
            ->with([
                'shipping',
                'user',
                'details.product',
                'details.buy',
                'details.stock.size',
                'details.product.colors',
                'shipping_address.country_state.country',
                'payments',
            ])
            ->paginate(20);

        return view('admin.buys.index', compact('buys'));
    }
}
