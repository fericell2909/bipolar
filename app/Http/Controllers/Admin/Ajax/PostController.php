<?php

namespace App\Http\Controllers\Admin\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'           => 'required|between:1,2000',
            'title_english'   => 'required|between:1,2000',
            'content'         => 'nullable|min:1',
            'content_english' => 'nullable|min:1',
        ]);

        $post = new Post;
        $post->setTranslations('title', [
            'es' => $request->input('title'),
            'en' => $request->input('title_english'),
        ]);
        $post->setTranslations('content', [
            'es' => $request->input('content'),
            'en' => $request->input('content_english'),
        ]);
        $post->save();

        return response()->json($post);
    }
}
