<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Http\Resources\TagResource;

class TagsController extends Controller
{
    public function index()
    {
        $tags = Tag::orderBy('name')->get();

        return TagResource::collection($tags);
    }
}
