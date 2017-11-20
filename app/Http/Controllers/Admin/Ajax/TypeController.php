<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeCollection;
use App\Models\Type;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::orderBy('name')->with('subtypes')->get();

        return new TypeCollection($types);
    }
}