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
            'name'         => 'required|string|max:255',
            'name_english' => 'required|string|max:255',
        ]);

        $color = new Color;
        $color->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
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
            'name'         => 'required|string|max:255',
            'name_english' => 'required|string|max:255',
        ]);

        $color = Color::findByHash($colorHashId);
        $color->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
        $color->save();

        flash()->success('Se actualizó con éxito');

        return redirect()->route('settings.colors');
    }

    public function delete($colorHashId)
    {
        $color = Color::findByHash($colorHashId);

        $color->products()->sync([]);
        try {
            $color->delete();
        } catch (\Exception $e) {
            flash()->error('No se pudo eliminar');
        }

        flash()->success('Eliminado correctamente');

        return response()->json(['message' => 'Eliminado correctamente']);
    }
}