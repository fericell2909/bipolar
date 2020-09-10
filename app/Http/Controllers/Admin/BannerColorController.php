<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerColorRequest;
use App\Models\Banner;
use App\Models\State;
use Carbon\Carbon;

class BannerColorController extends Controller
{
    public function index()
    {
        $banners = Banner::fromColorType()->with('state')->orderBy('order')->get();

        return view('admin.banners_colors.index', compact('banners'));
    }

    public function create()
    {
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.banners_colors.new', compact('states'));
    }

    public function store(BannerColorRequest $request)
    {
        /** @var State $state */
        $state = State::findOrFail($request->input('state'));

        $begin = $request->filled('begin') ? $request->input('begin') : now()->format('d/m/Y');
        $end = $request->filled('end') ? $request->input('end') : '31-12-2100';

        $banner = new Banner;
        $banner->begin_date = Carbon::createFromFormat('d/m/Y H:i', $begin);
        $banner->end_date = Carbon::createFromFormat('d/m/Y H:i', $end);
        $banner->setTranslations('text', [
            'en' => filled($request->input('text_eng')) ? $request->input('text_eng') : null,
            'es' => filled($request->input('text_spa')) ? $request->input('text_spa') : null,
        ]);
        $banner->background_color = $request->input('background_color');
        $banner->color = $request->input('color');
        $banner->link = filled($request->input('link')) ? $request->input('link') : null;
        $banner->state()->associate($state);
        $banner->save();

        return redirect()->route('banners_colors.set_text', $banner->id);
    }

    public function setText(int $id)
    {
        $banner = Banner::findOrFail($id);

        return view('admin.banners_colors.text', compact('banner'));
    }

    public function edit($bannerId)
    {
        $banner = Banner::findOrFail($bannerId);
        $states = State::orderBy('name')->get()->pluck('name', 'id')->toArray();

        return view('admin.banners_colors.edit', compact('banner', 'states'));
    }

    public function update(BannerColorRequest $request, $bannerId)
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
        $banner->link = filled($request->input('link')) ? $request->input('link') : null;
        $banner->font = $request->input('font');
        $banner->color = $request->input('color');
        $banner->background_color = $request->input('background_color');
        $banner->state()->associate($state);

        $banner->save();

        flash()->success('Se actualizó con éxito');

        return redirect()->back();
    }

    public function order()
    {
        $banners = Banner::fromColorType()->whereStateId(config('constants.STATE_ACTIVE_ID'))->orderBy('order')->get();

        return view('admin.banners_colors.order', compact('banners'));
    }

    public function preview($bannerId)
    {
        $banners = Banner::whereKey($bannerId)->get();

        return view('admin.banners.preview', compact('banners'));
    }
}
