<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Artesaos\SEOTools\Traits\SEOTools;

class HomeController extends Controller
{
    use SEOTools;

    public function page(string $pageSlug)
    {
        /** @var Page $page */
        $page = Page::findBySlugOrFail($pageSlug);
        /*
        if ($page->main_image) {
            $this->seo()->opengraph()->setType('article')->addImage($page->main_image);
            $this->seo()->twitter()->addImage($page->main_image);
        } else {
            $imageUrl = asset('storage/bipolar-images/assets/jeringas-rosado.jpg');
            $this->seo()->opengraph()->addImage($imageUrl);
            $this->seo()->twitter()->addImage($imageUrl);
        }
        */
        return view('web.landings.pages', compact('page'));
    }
}
