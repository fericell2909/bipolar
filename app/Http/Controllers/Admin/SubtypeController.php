<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subtype;
use Illuminate\Http\Request;

class SubtypeController extends Controller
{
    public function edit($subtypeHashId)
    {
        $subtype = Subtype::findByHash($subtypeHashId);

        return view('admin.subtypes.edit', compact('subtype'));
    }

    public function update(Request $request, $subtypeHashId)
    {
        $this->validate($request, ['name' => 'required|between:1,255']);

        $subtype = Subtype::findByHash($subtypeHashId);
        $subtype->name = $request->input('name');
        $subtype->save();

        flash()->success('Tipo actualizado con éxito');

        return redirect()->route('settings.types.subtypes', $subtype->type->hash_id);
    }
}