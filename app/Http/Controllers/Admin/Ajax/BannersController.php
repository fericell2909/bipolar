<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannersController extends Controller
{
    public function order(Request $request)
    {
        $this->validate($request, ['newOrder' => 'required|array']);

        $newOrder = $request->input('newOrder');

        foreach ($newOrder as $orderKey => $bannerId) {
            $banner = Banner::find($bannerId);
            $banner->order = $orderKey;
            $banner->save();
        }

        return response()->json(['success' => true]);
    }

    public function destroy($bannerId)
    {
        /** @var Banner $banner */
        $banner = Banner::findOrFail($bannerId);

        if (\Storage::disk('public')->exists($banner->relative_url)) {
            \Storage::disk('public')->delete($banner->relative_url);
        }

        try {
            $banner->delete();
        } catch (\Exception $e) {
            return response()->json(['success' => false]);
        }

        return response()->json(['success' => true]);
    }
}
