<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Mail\BuySent;
use App\Models\Buy;
use Illuminate\Http\Request;

class BuysController extends Controller
{
    public function sent(Request $request, $buyId)
    {
        /** @var Buy $buy */
        $buy = Buy::findOrFail($buyId);
        $buy->setStatus(config('constants.BUY_SENT_STATUS'), "Cambiando por {$request->user()->email} el " . date('d-m-Y'));

        if (boolval($buy->showroom) === false) {
            \Mail::to($buy->user->email)->send(new BuySent($buy));
        }

        return response()->json(['success' => true]);
    }
}
