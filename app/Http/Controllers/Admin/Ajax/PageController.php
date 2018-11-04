<?php

namespace App\Http\Controllers\Admin\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function store(Request $request)
    {
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

        return response()->json(['redirect_url' => route('page_admin.image', $page->id)]);
    }
}