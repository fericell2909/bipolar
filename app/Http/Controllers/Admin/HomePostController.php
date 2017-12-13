<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\HomePostNewRequest;
use App\Models\HomePost;
use App\Models\PostType;
use App\Models\State;
use App\Http\Controllers\Controller;

class HomePostController extends Controller
{
    public function create()
    {
        $postTypes = PostType::orderBy('name')->get()->pluck('name', 'id')->toArray();
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.home_posts.new', compact('postTypes', 'states'));
    }

    public function store(HomePostNewRequest $request)
    {
        $state = State::findOrFail($request->input('state'));
        $postType = PostType::findOrFail($request->input('post_type'));

        $homePost = new HomePost;
        $homePost->name = $request->input('name');
        $homePost->redirection_link = $request->input('link');
        $homePost->state()->associate($state);
        $homePost->post_type()->associate($postType);
        $homePost->save();

        flash('Creado con éxito')->success();

        return redirect()->route('homepost.photos', $homePost->slug);
    }

    public function show($homePostSlug)
    {
        $homePost = HomePost::findBySlugOrFail($homePostSlug);
        $postTypes = PostType::orderBy('name')->get()->pluck('name', 'id')->toArray();
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.home_posts.edit', compact('homePost', 'postTypes', 'states'));
    }

    public function update(HomePostNewRequest $request, $homePostSlug)
    {
        /** @var HomePost $homePost */
        $homePost = HomePost::findBySlugOrFail($homePostSlug);
        $state = State::findOrFail($request->input('state'));
        $postType = PostType::findOrFail($request->input('post_type'));

        $homePost->name = $request->input('name');
        $homePost->redirection_link = $request->input('link');
        $homePost->state()->associate($state);
        $homePost->post_type()->associate($postType);
        $homePost->save();

        flash('Actualizado con éxito')->success();

        return redirect()->back();
    }

    public function order()
    {
        $homePosts = HomePost::whereStateId(config('constants.STATE_ACTIVE_ID'))
            ->orderBy('order')
            ->get();

        return view('admin.home_posts.order', compact('homePosts'));
    }

    public function photoUpload($homePostSlug)
    {
        $homePost = HomePost::findBySlugOrFail($homePostSlug);

        return view('admin.home_posts.photos_upload', compact('homePost'));
    }
}
