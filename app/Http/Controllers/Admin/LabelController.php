<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Label;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::all();

        return view('admin.labels.list', compact('labels'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'         => 'required|between:1,255',
            'name_english' => 'required|between:1,255',
            'color'        => 'required|max:8',
        ]);


        $label = new Label();
        $label->setTranslations('name', [
            'es' => $request->input('name'),
            'en' => $request->input('name_english'),
        ]);
        $label->color = $request->input('color');
        $label->save();

        flash()->success('Label guardado con éxito');

        return back();
    }
}
