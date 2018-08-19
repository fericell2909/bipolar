<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Historic;

class HistoricsController extends Controller
{
    public function order(Request $request)
    {
        $this->validate($request, ['newOrder' => 'required|array']);

        $newOrder = $request->input('newOrder');

        $historics = Historic::all();

        foreach ($newOrder as $orderKey => $historicHashId) {
            $historic = $historics->filter(function ($historic) use ($historicHashId) {
                return $historic->hash_id === $historicHashId;
            })->first();
            $historic->order = $orderKey;
            $historic->save();
        }

        return response()->json(['success' => true]);
    }
}
