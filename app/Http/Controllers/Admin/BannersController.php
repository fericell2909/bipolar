<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BannerEditRequest;
use App\Http\Services\UploadFilePublic;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\State;
use App\Http\Requests\Admin\BannerNewRequest;
use Carbon\Carbon;

class BannersController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->with('state')->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.banners.new', compact('states'));
    }

    public function store(BannerNewRequest $request)
    {
        $fullPath = $imagePath = null;
        if ($request->file('photo')->isValid()) {
            $photoService = new UploadFilePublic;
            $imagePath = $photoService->uploadPhoto($request->file('photo'), "banners", "banner");
            $fullPath = $photoService->getFullUrl($imagePath);
        }

        /** @var State $state */
        $state = State::findOrFail($request->input('state'));

        $begin = $request->filled('begin') ? $request->input('begin') : now()->format('d/m/Y');
        $end = $request->filled('end') ? $request->input('end') : '31-12-2100';

        $banner = new Banner;
        $banner->url = $fullPath;
        $banner->relative_url = $imagePath;
        $banner->begin_date = Carbon::createFromFormat('d/m/Y', $begin);
        $banner->end_date = Carbon::createFromFormat('d/m/Y', $end);
        $banner->setTranslations('text', [
            'en' => filled($request->input('text_eng')) ? $request->input('text_eng') : null,
            'es' => filled($request->input('text_spa')) ? $request->input('text_spa') : null,
        ]);
        $banner->link = filled($request->input('link')) ? $request->input('link') : null;
        $banner->state()->associate($state);
        $banner->save();

        return redirect()->route('banners.index');
    }

    public function edit($bannerId)
    {
        $banner = Banner::findOrFail($bannerId);
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.banners.edit', compact('banner', 'states'));
    }

    public function update(BannerEditRequest $request, $bannerId)
    {
        /**
         * @var State $state
         * @var Banner $banner
         */
        $banner = Banner::findOrFail($bannerId);
        $state = State::findOrFail($request->input('state'));

        $begin = $request->filled('begin') ? $request->input('begin') : now()->format('Y-m-d H:i');
        $end = $request->filled('end') ? $request->input('end') : '2099-12-31 23:59';

        $banner->begin_date = Carbon::createFromFormat('d/m/Y', $begin);
        $banner->end_date = Carbon::createFromFormat('d/m/Y', $end);
        $banner->setTranslations('text', [
            'en' => filled($request->input('text_eng')) ? $request->input('text_eng') : null,
            'es' => filled($request->input('text_spa')) ? $request->input('text_spa') : null,
        ]);
        $banner->link = filled($request->input('link')) ? $request->input('link') : null;
        $banner->state()->associate($state);

        if ($request->file('photo')) {
            $photoService = new UploadFilePublic;
            $imagePath = $photoService->uploadPhoto($request->file('photo'), "banners", "banner");
            $fullPath = $photoService->getFullUrl($imagePath);
            $banner->url = $fullPath;
            $banner->relative_url = $imagePath;
        }

        $banner->save();

        flash()->success('Se actualizó con éxito');
        return redirect()->route('banners.index');
    }

    public function order()
    {
        $banners = Banner::whereStateId(config('constants.STATE_ACTIVE_ID'))->get();

        return view('admin.banners.order', compact('banners'));
    }
}
