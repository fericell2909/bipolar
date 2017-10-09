<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
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

        // todo: validate size has stocks

        $size->delete();

        flash()->success('Eliminado correctamente');

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}