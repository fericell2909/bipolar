<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\UploadFilePublic;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('title')->get();

        return view('admin.pages.list', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.new');
    }

    public function image($pageId)
    {
        $page = Page::findOrFail($pageId);

        return view('admin.pages.image', compact('page'));
    }

    public function imageUpload(Request $request, $pageId)
    {
        $this->validate($request, ['image' => 'file']);

        if (!$request->file('image')->isValid()) {
            return back();
        }

        /** @var Page $page */
        $page = Page::findOrFail($pageId);

        $image = $request->file('image');
        $photoService = new UploadFilePublic;
        $imagePath = $photoService->uploadPhoto($image, 'pages', $page->slug);
        $fullPath = $photoService->getFullUrl($imagePath) ?? "";

        $page->main_image = $fullPath;
        $page->save();

        flash()->success('Imagen guardada correctamente');

        return back();
    }
}