<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index()
    {
        $logs = Activity::orderByDesc('id')->with('causer')->paginate(20);

        return view('admin.logs', compact('logs'));
    }
}
