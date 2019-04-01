<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\BuySent;
use App\Models\Buy;
use Illuminate\Http\Request;

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
                'shipping_address',
                'billing_address',
                'payments',
            ])
            ->paginate(20);

        return view('admin.buys.index', compact('buys'));
    }

    public function edit($buyId)
    {
        /** @var Buy $buy */
        $buy = Buy::findOrFail($buyId);

        $statuses[config('constants.BUY_PROCESSING_STATUS')] = __('bipolar.buy.statuses.processing');

        if ($buy->showroom) {
            $statuses[config('constants.BUY_PICKUP_STATUS')] = __('bipolar.buy.statuses.pickup');
        } else {
            $statuses[config('constants.BUY_SENT_STATUS')] = __('bipolar.buy.statuses.sent');
        }

        $statuses[config('constants.BUY_CULMINATED_STATUS')] = __('bipolar.buy.statuses.culminated');

        return view('admin.buys.edit', compact('buy', 'statuses'));
    }

    public function update(Request $request, $buyId)
    {
        $this->validate($request, [
            'shipping_fee' => 'required|numeric|between:0,999.99',
            'total'        => 'required',
        ]);

        /** @var Buy $buy */
        $buy = Buy::findOrFail($buyId);

        $buy->shipping_fee = $request->input('shipping_fee');
        $buy->total = $request->input('total');
        if ($buy->status !== $request->input('status')) {
            if ($request->input('status') === config('constants.BUY_SENT_STATUS')) {
                $buy->setStatus(config('constants.BUY_SENT_STATUS'));
                $buy->setStatus(config('constants.BUY_TRANSIT_STATUS'));
                $languageOld = \LaravelLocalization::getCurrentLocale();
                \LaravelLocalization::setLocale($buy->currency === 'PEN' ? 'es' : 'en');
                \Mail::to($buy->user)->send(new BuySent($buy));
                \LaravelLocalization::setLocale($languageOld);
            } else {
                $buy->setStatus($request->input('status'));
            }
        }
        $buy->save();

        flash()->success('Actualizado con éxito');

        return redirect()->route('buys.index');
    }
}
