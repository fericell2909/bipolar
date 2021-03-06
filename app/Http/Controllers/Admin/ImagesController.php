<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\UploadFilePublic;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ImagesController extends Controller
{
    public function index()
    {
        $images = Image::orderByDesc('start_time')->get();

        return view('admin.images.index', compact('images'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'suscribe_image' => [
                'required',
                'image',
                Rule::dimensions()->width(1920)->height(991),
            ],
            'counter_image'  => [
                'required',
                'image',
                Rule::dimensions()->width(1920)->height(799),
            ],
            'start_date'     => 'required|date_format:d/m/Y H:i',
        ]);

        if (!$request->file('suscribe_image')->isValid()) {
            flash()->error('Hubo un problema con la imagen de suscripción, intenta nuevamente');

            return back();
        }

        if (!$request->file('counter_image')->isValid()) {
            flash()->error('Hubo un problema con la imagen del contador, intenta nuevamente');

            return back();
        }

        $startDate = Carbon::createFromFormat('d/m/Y H:i', $request->input('start_date'));

        $imageService = new UploadFilePublic();
        $pathSuscribeImage = $imageService->uploadPhoto($request->file('suscribe_image'), 'assets', 'suscribe');
        $pathCounterImage = $imageService->uploadPhoto($request->file('counter_image'), 'assets', 'counter');

        $image = new Image();
        $image->background_suscribe = $imageService->getFullUrl($pathSuscribeImage);
        $image->background_counter = $imageService->getFullUrl($pathCounterImage);
        $image->start_time = $startDate;
        $image->save();

        flash()->success('Guardado');

        return redirect()->route('backgrounds.all');
    }

    public function edit($imageId)
    {
        $image = Image::findOrFail($imageId);

        return view('admin.images.edit', compact('image'));
    }

    public function update(Request $request, $imageId)
    {
        $this->validate($request, [
            'suscribe_image' => [
                'nullable',
                'image',
                Rule::dimensions()->width(1920)->height(991),
            ],
            'counter_image'  => [
                'nullable',
                'image',
                Rule::dimensions()->width(1920)->height(799),
            ],
            'start_date'     => 'required|date_format:d/m/Y H:i',
        ]);

        $image = Image::findOrFail($imageId);

        $startDate = Carbon::createFromFormat('d/m/Y H:i', $request->input('start_date'));

        $imageService = new UploadFilePublic();

        if ($request->hasFile('suscribe_image')) {
            if (!$request->file('suscribe_image')->isValid()) {
                flash()->error('Hubo un problema con la imagen de suscripción, intenta nuevamente');

                return back();
            }

            $pathSuscribeImage = $imageService->uploadPhoto($request->file('suscribe_image'), 'assets', 'suscribe');
            $image->background_suscribe = $imageService->getFullUrl($pathSuscribeImage);
        }

        if ($request->hasFile('counter_image')) {
            if (!$request->file('counter_image')->isValid()) {
                flash()->error('Hubo un problema con la imagen del contador, intenta nuevamente');

                return back();
            }

            $pathCounterImage = $imageService->uploadPhoto($request->file('counter_image'), 'assets', 'counter');
            $image->background_counter = $imageService->getFullUrl($pathCounterImage);
        }

        $image->start_time = $startDate;
        $image->save();

        flash()->success('Actualizado');

        return redirect()->route('backgrounds.all');
    }

    public function delete($imageId)
    {
        $image = Image::findOrFail($imageId);

        if ($image->background_suscribe) {
            \Storage::disk('public')->delete($image->background_suscribe);
        }

        if ($image->background_counter) {
            \Storage::disk('public')->delete($image->background_counter);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }
}
