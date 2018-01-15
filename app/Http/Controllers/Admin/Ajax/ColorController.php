<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\ColorCollection;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::orderBy('name')->get();

        return new ColorCollection($colors);
    }
}