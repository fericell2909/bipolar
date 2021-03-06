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
        $banners = Banner::whereNull('background_color')->orderBy('order')->with('state')->get();

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
        $banner->begin_date = Carbon::createFromFormat('d/m/Y H:i', $begin);
        $banner->end_date = Carbon::createFromFormat('d/m/Y H:i', $end);
        $banner->setTranslations('text', [
            'en' => filled($request->input('text_eng')) ? $request->input('text_eng') : null,
            'es' => filled($request->input('text_spa')) ? $request->input('text_spa') : null,
        ]);
        $banner->link = filled($request->input('link')) ? $request->input('link') : null;
        $banner->state()->associate($state);
        $banner->save();

        return redirect()->route('banners.edit', $banner->id);
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

        $banner->begin_date = Carbon::createFromFormat('d/m/Y H:i', $begin);
        $banner->end_date = Carbon::createFromFormat('d/m/Y H:i', $end);
        $banner->setTranslations('text', [
            'en' => filled($request->input('text_eng')) ? $request->input('text_eng') : null,
            'es' => filled($request->input('text_spa')) ? $request->input('text_spa') : null,
        ]);
        $banner->link = filled($request->input('link')) ? $request->input('link') : null;
        $banner->font = $request->input('font');
        $banner->color = $request->input('color');
        $banner->font_size_mobile = $request->input('font_size_mobile');
        $banner->font_size_tablet = $request->input('font_size_tablet');
        $banner->font_size_desktop = $request->input('font_size_desktop');
        $banner->line_height_mobile = $request->input('line_height_mobile');
        $banner->line_height_tablet = $request->input('line_height_tablet');
        $banner->line_height_desktop = $request->input('line_height_desktop');
        $banner->letter_spacing_mobile = $request->input('letter_spacing_mobile');
        $banner->letter_spacing_tablet = $request->input('letter_spacing_tablet');
        $banner->letter_spacing_desktop = $request->input('letter_spacing_desktop');
        $banner->padding_bottom_mobile = $request->input('padding_bottom_mobile');
        $banner->padding_bottom_tablet = $request->input('padding_bottom_tablet');
        $banner->padding_bottom_desktop = $request->input('padding_bottom_desktop');
        $banner->state()->associate($state);

        if ($request->file('photo')) {
            $photoService = new UploadFilePublic;
            $imagePath = $photoService->uploadPhoto($request->file('photo'), "banners", "banner");
            $fullPath = $photoService->getFullUrl($imagePath);
            $banner->url = $fullPath;
            $banner->relative_url = $imagePath;
        }

        $banner->save();

        flash()->success('Se actualiz?? con ??xito');

        return redirect()->back();
    }

    public function order()
    {
        $banners = Banner::whereStateId(config('constants.STATE_ACTIVE_ID'))->orderBy('order')->whereNull('background_color')->get();

        return view('admin.banners.order', compact('banners'));
    }

    public function preview($bannerId)
    {
        $bannersForFind = Banner::whereKey($bannerId)->get();
        $banners = $bannersForFind->filter(function ($banner) {
            return $banner->background_color === null;
        });
        $bannerColors = $bannersForFind->filter(function ($banner) {
            return $banner->background_color !== null;
        });

        return view('admin.banners.preview', compact('banners', 'bannerColors'));
    }
}
