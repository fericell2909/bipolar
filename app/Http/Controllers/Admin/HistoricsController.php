<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Historic;

class HistoricsController extends Controller
{
    public function index()
    {
        $historics = Historic::orderByDesc('order')->get();

        return view('admin.historics.index', compact('historics'));
    }
}
