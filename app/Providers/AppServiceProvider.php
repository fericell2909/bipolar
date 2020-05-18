<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Page;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Sharing the pages for footer
        $pagesForFooter = Page::select(['id', 'slug', 'title'])->get();
        $bannerColors = Banner::orderBy('order')
            ->whereNotNull('background_color')
            ->where('state_id', config('constants.STATE_ACTIVE_ID'))
            ->where('begin_date', '<=', now())
            ->where('end_date', '>=', now())
            ->get();

        \View::share('pagesForFooter', $pagesForFooter);
        \View::share('bannerColors', $bannerColors);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
