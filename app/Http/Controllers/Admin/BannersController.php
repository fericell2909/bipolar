<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BannerEditRequest;
use App\Http\Services\UploadFileS3;
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
        $amazonPath = null;
        if ($request->file('photo')->isValid()) {
            $s3 = new UploadFileS3;
            $imagePath = $s3->uploadPhoto($request->file('photo'), "banners", "banner");
            $amazonPath = $s3->getAmazonPath($imagePath);
        }

        /** @var State $state */
        $state = State::findOrFail($request->input('state'));

        $banner = new Banner;
        $banner->url = $amazonPath;
        $banner->begin_date = Carbon::createFromFormat('Y-m-d H:i', $request->input('begin'));
        $banner->end_date = Carbon::createFromFormat('Y-m-d H:i', $request->input('end'));
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

        $banner->begin_date = Carbon::createFromFormat('Y-m-d H:i', $request->input('begin'));
        $banner->end_date = Carbon::createFromFormat('Y-m-d H:i', $request->input('end'));
        $banner->state()->associate($state);

        if ($request->file('photo')) {
            $s3 = new UploadFileS3;
            $imagePath = $s3->uploadPhoto($request->file('photo'), "banners", "banner");
            $amazonPath = $s3->getAmazonPath($imagePath);
            $banner->url = $amazonPath;
        }

        $banner->save();

        flash()->success('Se actualizó con éxito');
        return redirect()->route('banners.index');
    }
}
