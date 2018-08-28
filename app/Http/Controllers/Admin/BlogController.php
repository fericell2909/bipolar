<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class BlogController extends Controller
{
    public function create()
    {
        return view('admin.blog.new');
    }

    public function index()
    {
        $posts = Post::orderByDesc('id')->with('tags', 'categories', 'state')->get();

        return view('admin.blog.index', compact('posts'));
    }

    public function edit($postId)
    {
        $post = Post::findOrFail($postId);

        return view('admin.blog.edit', compact('post'));
    }

    public function photos($postId)
    {
        $post = Post::findOrFail($postId);

        return view('admin.blog.photos', compact('post'));
    }

    public function order($postId)
    {
        $post = Post::findOrFail($postId);

        $post->load(['photos' => function ($withPhotos) {
            return $withPhotos->orderBy('order');
        }]);

        return view('admin.blog.order', compact('post'));
    }
}
