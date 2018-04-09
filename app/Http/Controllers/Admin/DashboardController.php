<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buy;
use App\Models\BuyDetail;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $usersInWeek = User::whereDate('created_at', '>=', now()->startOfWeek())->whereDate('created_at', '<=', now()->endOfWeek())->count();
        $usersTotal = User::count();
        $firstBuyUsers = User::whereHas('buys', function ($whereBuys) {
            $whereBuys->whereDate('created_at', '>=', now()->startOfWeek());
            $whereBuys->whereDate('created_at', '<=', now()->endOfWeek());
        })->count();
        $buysInWeek = Buy::with('details')
            ->whereDate('created_at', '>=', now()->startOfWeek())
            ->whereDate('created_at', '<=', now()->endOfWeek())
            ->get();
        $sumTotalBuys = $buysInWeek->sum('total');
        $productsBuyWeek = $buysInWeek->each->details->sum('quantity');
        $cartsInWeek = Cart::has('details')
            ->whereDate('created_at', '>=', now()->startOfWeek())
            ->whereDate('created_at', '<=', now()->endOfWeek())
            ->count();

        return view('admin.home', compact('usersInWeek', 'firstBuyUsers', 'sumTotalBuys', 'productsBuyWeek', 'cartsInWeek', 'usersTotal'));
    }
}
