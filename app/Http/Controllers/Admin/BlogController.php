<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Spatie\Regex\Regex;

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

    public function video($postId)
    {
        $post = Post::findOrFail($postId);

        return view('admin.blog.video', compact('post'));
    }

    public function saveVideo(Request $request, $postId)
    {
        $this->validate($request, ['video' => 'required']);

        $post = Post::findOrFail($postId);

        $videoRegex = Regex::match('/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/', $request->input('video'));

        if (!$videoRegex->hasMatch()) {
            flash()->error('Por favor ingrese una dirección de youtube correcta');
            return back();
        }

        $youtubeVideoId = $videoRegex->group(2);
        $youtubeEmbeddedUrl = "//www.youtube.com/embed/{$youtubeVideoId}"; 
        
        $post->main_video = $youtubeEmbeddedUrl;
        $post->save();

        flash()->success('Guardado correctamente');

        return back();
    }

    public function removeVideo($postId)
    {
        $post = Post::findOrFail($postId);
        $post->main_video = null;
        $post->save();

        flash()->success('Video quitado de la publicación');
        return back();
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
