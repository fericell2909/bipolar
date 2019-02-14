<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    public function index()
    {
        $types = Type::orderBy('order')->get();

        return view('admin.types.list', compact('types'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|between:1,255',
            'name_english' => 'required|between:1,255',
        ]);

        $type = new Type;
        $type->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
        $type->save();

        flash()->success('Tipo creado correctamente');

        return redirect()->route('settings.types');
    }

    public function edit($typeHashId)
    {
        $type = Type::findByHash($typeHashId);

        return view('admin.types.edit', compact('type'));
    }

    public function update(Request $request, $typeHashId)
    {
        $this->validate($request, [
            'name'         => 'required|between:1,255',
            'name_english' => 'required|between:1,255',
        ]);

        $type = Type::findByHash($typeHashId);
        $type->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
        $type->save();

        flash()->success('Tipo actualizado correctamente');

        return redirect()->route('settings.types');
    }

    public function delete($typeHashId)
    {
        $type = Type::findByHash($typeHashId);

        if (count($type->subtypes) == 0) {
            $type->delete();
        } else {
            flash()->error('No se puede eliminar un producto con subtipos registrados');
        }

        return response()->json(['success' => true]);
    }

    public function subtypes($typeHashId)
    {
        $type = Type::findByHash($typeHashId);

        return view('admin.types.subtypes', compact('type'));
    }
}