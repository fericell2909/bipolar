<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subtype;
use App\Models\Type;
use Illuminate\Http\Request;

class SubtypeController extends Controller
{
    public function create(Request $request, $typeHashId)
    {
        $this->validate($request, [
            'name'         => 'required|between:1,255',
            'name_english' => 'required|between:1,255',
        ]);

        $type = Type::findByHash($typeHashId);

        $subtype = new Subtype;
        $subtype->type()->associate($type);
        $subtype->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
        $subtype->save();

        flash()->success('Subtipo creado con éxito');

        return redirect()->route('settings.types.subtypes', $type->hash_id);
    }

    public function edit($subtypeHashId)
    {
        $subtype = Subtype::findByHash($subtypeHashId);

        return view('admin.subtypes.edit', compact('subtype'));
    }

    public function update(Request $request, $subtypeHashId)
    {
        $this->validate($request, [
            'name'         => 'required|between:1,255',
            'name_english' => 'required|between:1,255',
            'order'        => 'required|between:1,255',
        ]);

        $subtype = Subtype::findByHash($subtypeHashId);
        $subtype->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
        $subtype->order = $request->input('order');
        $subtype->save();

        flash()->success('Tipo actualizado con éxito');

        return redirect()->route('settings.types.subtypes', $subtype->type->hash_id);
    }
}