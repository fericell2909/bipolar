<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Historic;
use App\Http\Services\UploadFileS3;
use App\Http\Requests\Admin\HistoricNewRequest;

class HistoricsController extends Controller
{
    public function index()
    {
        $historics = Historic::orderByDesc('order')->get();

        return view('admin.historics.index', compact('historics'));
    }

    public function create()
    {
        return view('admin.historics.new');
    }

    public function store(HistoricNewRequest $request)
    {
        if ($request->file('photo')->isValid()) {
            $s3 = new UploadFileS3;
            $imagePath = $s3->uploadPhoto($request->file('photo'), "banners", "banner");
            $amazonPath = $s3->getAmazonPath($imagePath);
        }

        $historic = new Historic;
        $historic->name = $request->input('name');
        $historic->order = Historic::count();
        $historic->photo = $amazonPath;
        $historic->photo_relative = $imagePath;
        $historic->save();

        flash()->success('Guardado con éxito');
        return redirect()->back();
    }
}
