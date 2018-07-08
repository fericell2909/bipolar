<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::orderBy('name')->get();

        return CategoryResource::collection($category);
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|between:1,225']);

        $category = new Category;
        $category->name = $request->input('name');
        $category->save();

        return new CategoryResource($category);
    }
}
