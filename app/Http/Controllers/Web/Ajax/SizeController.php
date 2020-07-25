<?php

namespace App\Http\Controllers\Web\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function calculate(Request $request)
    {
        $this->validate($request, [
            'common_size'  => "required",
            'foot_width'   => "required",
            'foot_instep'  => "required",
            'product_uuid' => "required",
        ]);

        $product = Product::whereUuid($request->input('product_uuid'))->firstOrFail();

        $size = (float)$request->input('common_size');

        switch ($request->input('foot_width')) {
            case config('constants.FIT_VERY_LOW'):
                $size += $product->width_level_very_low;
                break;
            case config('constants.FIT_LOW'):
                $size += $product->width_level_low;
                break;
            case config('constants.FIT_NORMAL'):
                $size += $product->width_level_normal;
                break;
            case config('constants.FIT_HIGH'):
                $size += $product->width_level_high;
                break;
            case config('constants.FIT_VERY_HIGH'):
                $size += $product->width_level_very_high;
                break;
        }

        switch ($request->input('foot_instep')) {
            case config('constants.FIT_VERY_LOW'):
                $size += $product->instep_level_very_low;
                break;
            case config('constants.FIT_LOW'):
                $size += $product->instep_level_low;
                break;
            case config('constants.FIT_NORMAL'):
                $size += $product->instep_level_normal;
                break;
            case config('constants.FIT_HIGH'):
                $size += $product->instep_level_high;
                break;
            case config('constants.FIT_VERY_HIGH'):
                $size += $product->instep_level_very_high;
                break;
        }

        if (\Auth::check()) {
            $user = \Auth::user();
            $user->common_size = $request->input('common_size');
            $user->foot_width = $request->input('foot_width');
            $user->foot_instep = $request->input('foot_instep');
            $user->save();
        }

        return ['result' => $size, 'success' => true];
    }
}
