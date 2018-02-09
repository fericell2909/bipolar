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

        foreach ($newOrder as $orderKey => $historicId) {
            $historic = $historics->filter(function ($historic) use ($historicId) {
                return $historic->id == $historicId;
            })->first();
            $historic->order = $orderKey;
            $historic->save();
        }

        return response()->json(['success' => true]);
    }
}
