<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\StateCollection;
use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        $states = State::orderBy('name')->get();

        return new StateCollection($states);
    }
}