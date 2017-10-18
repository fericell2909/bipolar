<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    public function index()
    {
        $types = Type::orderByDesc('id')->get();

        return view('admin.types.list', compact('types'));
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|between:1,255']);

        $type = new Type;
        $type->name = $request->input('name');
        $type->save();

        flash()->success('Tipo creado correctamente');

        return redirect()->route('settings.types');
    }
}