<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\State;
use App\Models\Category;
use App\Models\Tag;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'           => 'required|between:1,2000',
            'title_english'   => 'required|between:1,2000',
            'content'         => 'nullable|min:1',
            'content_english' => 'nullable|min:1',
            'state'           => 'required',
            'categories'      => 'array',
            'tags'            => 'array',
        ]);

        $state = State::findByHash($request->input('state'));

        $post = new Post;
        $post->setTranslations('title', [
            'es' => $request->input('title'),
            'en' => $request->input('title_english'),
        ]);
        $post->setTranslations('content', [
            'es' => $request->input('content'),
            'en' => $request->input('content_english'),
        ]);
        $post->state()->associate($state);
        $post->save();

        if (count($request->input('categories')) > 0) {
            $categories = Category::findByManyHash($request->input('categories'))->pluck('id')->toArray();
            $post->categories()->sync($categories);
        }

        if (count($request->input('tags')) > 0) {
            $tags = Tag::findByManyHash($request->input('tags'))->pluck('id')->toArray();
            $post->tags()->sync($tags);
        }

        return response()->json([
            'redirect_url' => route('blog.index'),
        ]);
    }

    public function show($postId)
    {
        $post = Post::findOrFail($postId);

        return new PostResource($post);
    }

    public function update(Request $request, $postId)
    {
        $this->validate($request, [
            'title' => 'required|between:1,2000',
            'title_english' => 'required|between:1,2000',
            'content' => 'nullable|min:1',
            'content_english' => 'nullable|min:1',
            'state' => 'required',
            'categories' => 'array',
            'tags' => 'array',
        ]);

        $state = State::findByHash($request->input('state'));

        /** @var Post $post */
        $post = Post::findOrFail($postId);
        $post->setTranslations('title', [
            'es' => $request->input('title'),
            'en' => $request->input('title_english'),
        ]);
        $post->setTranslations('content', [
            'es' => $request->input('content'),
            'en' => $request->input('content_english'),
        ]);
        $post->state()->associate($state);
        $post->save();

        if (count($request->input('categories')) > 0) {
            $categories = Category::findByManyHash($request->input('categories'))->pluck('id')->toArray();
            $post->categories()->sync($categories);
        } else {
            $post->categories()->detach();
        }

        if (count($request->input('tags')) > 0) {
            $tags = Tag::findByManyHash($request->input('tags'))->pluck('id')->toArray();
            $post->tags()->sync($tags);
        } else {
            $post->tags()->detach();
        }

        return response()->json([
            'redirect_url' => route('blog.index'),
        ]);
    }

    public function order(Request $request)
    {
        $this->validate($request, ['newOrder' => 'required|array']);

        $newOrder = $request->input('newOrder');

        foreach ($newOrder as $orderKey => $bannerId) {
            $banner = Photo::findByHash($bannerId);
            $banner->order = $orderKey;
            $banner->save();
        }

        return response()->json(['success' => true]);
    }

    public function remove($blogPostId)
    {
        $post = Post::findOrFail($blogPostId);

        $post->photos->each(function ($photo) {
            $photo->delete();
        });

        $post->categories()->sync([]);
        $post->tags()->sync([]);

        $post->delete();

        return response()->json(['success' => true]);
    }
}
