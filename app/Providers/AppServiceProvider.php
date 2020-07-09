<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Page;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\Telescope;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
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
        Telescope::ignoreMigrations();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
