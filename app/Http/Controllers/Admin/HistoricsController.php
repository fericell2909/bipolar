<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Historic;
use App\Http\Services\UploadFilePublic;
use App\Http\Requests\Admin\HistoricNewRequest;
use App\Http\Requests\Admin\HistoricEditRequest;

class HistoricsController extends Controller
{
    public function index()
    {
        $historics = Historic::orderByDesc('order')->get();

        return view('admin.historics.index', compact('historics'));
    }

    public function create()
    {
        return view('admin.historics.new');
    }

    public function store(HistoricNewRequest $request)
    {
        if ($request->file('photo')->isValid()) {
            $photoService = new UploadFilePublic;
            $imagePath = $photoService->uploadPhoto($request->file('photo'), "historicos", "historico");
            $fullPath = $photoService->getFullUrl($imagePath);
        }

        $historic = new Historic;
        $historic->name = $request->input('name');
        $historic->order = Historic::count() + 1;
        $historic->photo = $fullPath;
        $historic->photo_relative = $imagePath;
        $historic->save();

        flash()->success('Guardado con éxito');
        return redirect()->back();
    }

    public function edit($historicId)
    {
        $historic = Historic::findOrFail($historicId);

        return view('admin.historics.edit', compact('historic'));
    }

    public function update(HistoricEditRequest $request, $historicId)
    {
        $historic = Historic::findOrFail($historicId);

        if ($request->file('photo')) {
            $photoService = new UploadFilePublic;
            $imagePath = $photoService->uploadPhoto($request->file('photo'), "historicos", "historic");
            $amazonPath = $photoService->getFullUrl($imagePath);
            $historic->photo = $amazonPath;
            $historic->photo_relative = $imagePath;
        }

        $historic->name = $request->input('name');
        $historic->save();

        flash()->success('Actualizado correctamente');
        return redirect()->back();
    }

    public function order()
    {
        $historics = Historic::orderBy('order')->get();

        return view('admin.historics.order', compact('historics'));
    }

    public function trashed()
    {
        $historics = Historic::onlyTrashed()->get();

        return view('admin.historics.trashed', compact('historics'));
    }

    public function restore($historicId)
    {
        $historic = Historic::onlyTrashed()->whereId($historicId)->firstOrFail();
        $historic->restore();

        flash()->success('Restaurado con éxito');
        return redirect()->back();
    }

    public function trash($historicId)
    {
        $historic = Historic::findOrFail($historicId);

        try {
            $historic->delete();
        } catch (\Exception $e) {
            flash()->error('No se pudo eliminar');
            return redirect()->back();
        }

        flash()->success('Eliminado con éxito');
        return redirect()->back();
    }

    public function destroy($historicId)
    {
        /** @var Historic $historic */
        $historic = Historic::onlyTrashed()->whereId($historicId)->firstOrFail();

        try {
            if (\Storage::disk('public')->exists($historic->photo_relative)) {
                \Storage::disk('public')->delete($historic->photo_relative);
            }
            $historic->forceDelete();
        } catch (\Exception $e) {
            flash()->error('No se pudo eliminar');
            return redirect()->back();
        }

        flash()->success('Destruido con éxito');
        return redirect()->back();
    }
}
