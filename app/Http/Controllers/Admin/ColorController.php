<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::orderByDesc('id')->get();

        return view('admin.settings.colors', compact('colors'));
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required|string|max:255',
            'hexadecimal' => 'required|string|max:10',
        ]);

        $color = new Color;
        $color->name = $request->input('name');
        $color->hexadecimal = $request->input('hexadecimal');
        $color->save();

        flash()->success('Registrado con éxito');

        return redirect()->back();
    }

    public function show($colorHashId)
    {
        $color = Color::findByHash($colorHashId);

        return view('admin.settings.color_edit', compact('color'));
    }

    public function update(Request $request, $colorHashId)
    {
        $this->validate($request, [
            'name'        => 'required|string|max:255',
            'hexadecimal' => 'required|string|max:10',
        ]);

        $color = Color::findByHash($colorHashId);
        $color->name = $request->input('name');
        $color->hexadecimal = $request->input('hexadecimal');
        $color->save();

        flash()->success('Se actualizó con éxito');

        return redirect()->route('settings.colors');
    }

    public function delete($colorHashId)
    {
        $color = Color::findByHash($colorHashId);

        // todo: check if color has products

        $color->delete();

        flash()->success('Eliminado correctamente');

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}