<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use SEOTools;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $imageUrl = asset('storage/bipolar-images/assets/jeringas-rosado.jpg');
        $this->seo()->opengraph()->addImage($imageUrl);
        $this->seo()->twitter()->addImage($imageUrl);
    }

    public function page(string $pageSlug)
    {
        $page = Page::findBySlugOrFail($pageSlug);

        return view('web.landings.pages', compact('page'));
    }
}
