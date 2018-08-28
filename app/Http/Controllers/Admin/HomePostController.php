<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\HomePostNewRequest;
use App\Models\HomePost;
use App\Models\PostType;
use App\Models\State;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePostController extends Controller
{
    public function index()
    {
        $homePosts = HomePost::orderByDesc('id')->with('photos', 'state')->get();

        return view('admin.home_posts.list', compact('homePosts'));
    }

    public function create()
    {
        $postTypes = PostType::orderBy('name')->get()->pluck('name', 'id')->toArray();
        $postTypes = array_prepend($postTypes, 'Seleccione', '');
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.home_posts.new', compact('postTypes', 'states'));
    }

    public function store(HomePostNewRequest $request)
    {
        $state = State::findOrFail($request->input('state'));

        $homePost = new HomePost;
        $homePost->name = $request->input('name');
        $homePost->redirection_link = $request->input('link');
        $homePost->state()->associate($state);
        if ($request->filled('post_type')) {
            $postType = PostType::findOrFail($request->input('post_type'));
            $homePost->post_type()->associate($postType);
        }

        $homePost->save();

        flash('Creado con éxito')->success();

        return redirect()->route('homepost.photos', $homePost->slug);
    }

    public function show($homePostSlug)
    {
        $homePost = HomePost::findBySlugOrFail($homePostSlug);
        $postTypes = PostType::orderBy('name')->get()->pluck('name', 'id')->toArray();
        $postTypes = array_prepend($postTypes, 'Seleccione', '');
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.home_posts.edit', compact('homePost', 'postTypes', 'states'));
    }

    public function update(HomePostNewRequest $request, $homePostSlug)
    {
        /** @var HomePost $homePost */
        $homePost = HomePost::findBySlugOrFail($homePostSlug);
        $state = State::findOrFail($request->input('state'));

        $homePost->name = $request->input('name');
        $homePost->redirection_link = $request->input('link');
        $homePost->state()->associate($state);
        if ($request->filled('post_type')) {
            $postType = PostType::findOrFail($request->input('post_type'));
            $homePost->post_type()->associate($postType);
        }

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

    public function orderPhotos($homePostSlug)
    {
        $homePost = HomePost::findBySlugOrFail($homePostSlug);

        return view('admin.home_posts.photos_order', compact('homePost'));
    }

    public function showTypes()
    {
        $postTypes = PostType::all();

        return view('admin.home_posts.types', compact('postTypes'));
    }

    public function storeType(Request $request)
    {
        $this->validate($request, [
            'name_spa' => 'required|between:1,255',
            'name_eng' => 'required|between:1,255',
        ]);

        $homePostType = new PostType;
        $homePostType->setTranslations('name', [
            'en' => $request->input('name_eng'),
            'es' => $request->input('name_spa'),
        ]);
        $homePostType->save();

        flash()->success('Guardado correctamente');

        return redirect()->back();
    }

    public function editType($postTypeId)
    {
        $postType = PostType::findOrFail($postTypeId);

        return view('admin.home_posts.types_edit', compact('postType'));
    }

    public function updateType($postTypeId, Request $request)
    {
        $this->validate($request, [
            'name_spa' => 'required|between:1,255',
            'name_eng' => 'required|between:1,255',
        ]);
        
        $postType = PostType::findOrFail($postTypeId);
        $postType->setTranslations('name', [
            'en' => $request->input('name_eng'),
            'es' => $request->input('name_spa'),
        ]);
        $postType->save();

        flash()->success('Actualizado correctamente');

        return redirect()->route('homepost.types');
    }
}
