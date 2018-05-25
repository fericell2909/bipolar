<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeCollection;
use App\Models\Subtype;
use App\Models\Type;
use App\Http\Resources\Subtype as SubtypeResource;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::orderBy('name')->with('subtypes')->get();

        return new TypeCollection($types);
    }

    public function subtypes()
    {
        $subtypes = Subtype::orderBy('name')->get();

        return SubtypeResource::collection($subtypes);
    }
}