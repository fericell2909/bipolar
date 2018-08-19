<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\UploadFilePublic;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class BackgroundController extends Controller
{
    public function collection()
    {
        $setting = Settings::first();

        return view('admin.settings.backgrounds', compact('setting'));
    }

    public function suscribe(Request $request)
    {
        $this->validate($request, [
            'suscribe_image' => [
                'required',
                'image',
                Rule::dimensions()->width(1920)->height(991),
            ],
        ]);

        $setting = Settings::first();

        if (!$request->file('suscribe_image')->isValid()) {
            flash()->error('Hubo un problema con la imagne, intenta nuevamente');
            return back();
        }

        if ($setting->background_suscribe) {
            \Storage::disk('public')->delete($setting->background_suscribe);
        }

        $imageService = new UploadFilePublic();
        $path = $imageService->uploadPhoto($request->file('suscribe_image'), 'assets', 'suscribe');
        $setting->background_suscribe = $imageService->getFullUrl($path);
        $setting->save();

        flash()->success('Guardado');

        return back();
    }
}
