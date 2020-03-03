<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LabelCollection;
use App\Models\Label;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::all();

        return new LabelCollection($labels);
    }
}
