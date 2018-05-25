<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        $settings = Settings::first();

        return view('admin.settings.general', compact('settings'));
    }

    public function saveGeneral(Request $request)
    {
        $this->validate($request, [
            'bipolar_counts'   => 'required|integer|min:0',
            'instagram_counts' => 'required|integer|min:0',
            'dolar_price'      => 'required|numeric|min:0',
            'free_shipping'    => 'nullable|boolean',
        ]);

        $settings = Settings::first();
        $settings->bipolar_counts = $request->input('bipolar_counts');
        $settings->instagram_counts = $request->input('instagram_counts');
        $settings->dolar_change = $request->input('dolar_price');
        $settings->free_shipping = $request->input('free_shipping', false);
        $settings->save();

        flash()->success('Guardado con éxito');

        return redirect()->back();
    }

    public function seeSizes()
    {
        $sizes = Size::orderBy('name')->get();

        return view('admin.settings.sizes', compact('sizes'));
    }

    public function saveSize(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        $size = new Size;
        $size->name = $request->input('name');
        $size->save();

        flash()->success('Talla registrada');

        return redirect()->back();
    }

    public function showSize($sizeHashId)
    {
        $size = Size::findByHash($sizeHashId);

        return view('admin.settings.size_edit', compact('size'));
    }

    public function updateSize(Request $request, $sizeHashId)
    {
        $this->validate($request, ['name' => 'required']);

        $size = Size::findByHash($sizeHashId);

        $size->name = $request->input('name');
        $size->save();

        flash()->success('Se actualizó con éxito');

        return redirect()->route('settings.sizes');
    }

    public function deleteSize($sizeHashId)
    {
        $size = Size::findByHash($sizeHashId);

        if ($size->stocks->count()) {
            flash()->error('La talla tiene productos asociados');
        }

        $size->delete();

        flash()->success('Eliminado correctamente');

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}
