<?php

namespace App\Http\Controllers\Admin;

use App\Models\Buy;
use App\Models\Cart;
use App\Models\User;
use App\Http\Controllers\Controller;
use Newsletter;
use Spatie\Analytics\Period;

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

        $newsletterUsersInWeek = 0;
        $visitorsThisWeek = 0;

        if (config('app.mailchimp_key')) {
            $newsletterUsersInWeek = Newsletter::getApi()->get('lists/' . config('app.mailchimp_list_id') . '/members', [
                'since_timestamp_opt'  => now()->startOfWeek()->toIso8601String(),
                'before_timestamp_opt' => now()->endOfWeek()->toIso8601String(),
            ]);

            $newsletterUsersInWeek = array_get($newsletterUsersInWeek, 'total_items', 0);
        }

        $visitorsThisWeek = $this->getVisitors();

        return view('admin.home', compact('usersInWeek', 'firstBuyUsers', 'sumTotalBuys', 'productsBuyWeek', 'cartsInWeek', 'usersTotal', 'newsletterUsersInWeek', 'visitorsThisWeek'));
    }

    private function getVisitors()
    {
        try {
            return \Analytics::fetchVisitorsAndPageViews(Period::create(now()->startOfWeek(), now()->endOfWeek()))->sum('visitors');
        } catch (\Exception $e) {
            // Nothing
            return 0;
        }
    }
}
