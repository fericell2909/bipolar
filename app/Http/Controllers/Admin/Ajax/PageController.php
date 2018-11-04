<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($pageId)
    {
        $page = Page::findOrFail($pageId);

        return new PageResource($page);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'           => 'required',
            'title_english'   => 'required',
            'content'         => 'required',
            'content_english' => 'required',
        ]);

        $page = new Page;
        $page->setTranslations('title', [
            'es' => $request->input('title'),
            'en' => $request->input('title_english'),
        ]);
        $page->setTranslations('body', [
            'es' => $request->input('content'),
            'en' => $request->input('content_english'),
        ]);
        $page->save();

        flash()->success('Página guardada correctamente');

        return response()->json(['redirect_url' => route('page_admin.image', $page->id)]);
    }

    public function update(Request $request, $pageId)
    {
        $this->validate($request, [
            'title'           => 'required',
            'title_english'   => 'required',
            'content'         => 'required',
            'content_english' => 'required',
        ]);

        /** @var Page $page */
        $page = Page::findOrFail($pageId);
        $page->setTranslations('title', [
            'es' => $request->input('title'),
            'en' => $request->input('title_english'),
        ]);
        $page->setTranslations('body', [
            'es' => $request->input('content'),
            'en' => $request->input('content_english'),
        ]);
        $page->save();

        flash()->success('Página actualizada correctamente');

        return response()->json(['redirect_url' => route('page_admin.image', $page->id)]);
    }
}