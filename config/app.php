<?php

return [

    'name' => env('APP_NAME', 'Bipolar'),

    'env' => env('APP_ENV', 'production'),

    'debug' => (bool)env('APP_DEBUG', false),

    'url' => env('APP_URL', 'http://localhost'),

    'timezone' => 'America/Lima',

    'locale' => 'es',

    'fallback_locale' => 'es',

    'key' => env('APP_KEY'),

    'cipher'     => 'AES-256-CBC',

    // AWS S3
    'aws_bucket' => env('AWS_BUCKET'),

    'facebook_id'   => env("FACEBOOK_APP_API"),

    // Mailchimp
    'mailchimp_key' => env('MAILCHIMP_APIKEY'),

    'mailchimp_list_id' => env('MAILCHIMP_LIST_ID'),

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Laravel\Tinker\TinkerServiceProvider::class,
        Barryvdh\Debugbar\ServiceProvider::class,
        Collective\Html\HtmlServiceProvider::class,
        Laracasts\Flash\FlashServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\TelescopeServiceProvider::class,
        App\Providers\HorizonServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Maatwebsite\Excel\ExcelServiceProvider::class,
        Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class,
        Vinkla\Hashids\HashidsServiceProvider::class,
        Jenssegers\Agent\AgentServiceProvider::class,
        Ip2location\IP2LocationLaravel\IP2LocationLaravelServiceProvider::class,

        Biscolab\ReCaptcha\ReCaptchaServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'                 => Illuminate\Support\Facades\App::class,
        'Artisan'             => Illuminate\Support\Facades\Artisan::class,
        'Auth'                => Illuminate\Support\Facades\Auth::class,
        'Blade'               => Illuminate\Support\Facades\Blade::class,
        'Broadcast'           => Illuminate\Support\Facades\Broadcast::class,
        'Bus'                 => Illuminate\Support\Facades\Bus::class,
        'Cache'               => Illuminate\Support\Facades\Cache::class,
        'Config'              => Illuminate\Support\Facades\Config::class,
        'Cookie'              => Illuminate\Support\Facades\Cookie::class,
        'Crypt'               => Illuminate\Support\Facades\Crypt::class,
        'DB'                  => Illuminate\Support\Facades\DB::class,
        'Eloquent'            => Illuminate\Database\Eloquent\Model::class,
        'Event'               => Illuminate\Support\Facades\Event::class,
        'File'                => Illuminate\Support\Facades\File::class,
        'Gate'                => Illuminate\Support\Facades\Gate::class,
        'Hash'                => Illuminate\Support\Facades\Hash::class,
        'Lang'                => Illuminate\Support\Facades\Lang::class,
        'Log'                 => Illuminate\Support\Facades\Log::class,
        'Mail'                => Illuminate\Support\Facades\Mail::class,
        'Notification'        => Illuminate\Support\Facades\Notification::class,
        'Password'            => Illuminate\Support\Facades\Password::class,
        'Queue'               => Illuminate\Support\Facades\Queue::class,
        'Redirect'            => Illuminate\Support\Facades\Redirect::class,
        'Redis'               => Illuminate\Support\Facades\Redis::class,
        'Request'             => Illuminate\Support\Facades\Request::class,
        'Response'            => Illuminate\Support\Facades\Response::class,
        'Route'               => Illuminate\Support\Facades\Route::class,
        'Schema'              => Illuminate\Support\Facades\Schema::class,
        'Session'             => Illuminate\Support\Facades\Session::class,
        'Storage'             => Illuminate\Support\Facades\Storage::class,
        'URL'                 => Illuminate\Support\Facades\URL::class,
        'Validator'           => Illuminate\Support\Facades\Validator::class,
        'View'                => Illuminate\Support\Facades\View::class,


        /* Third party facades */
        'Debugbar'            => Barryvdh\Debugbar\Facade::class,
        'Form'                => Collective\Html\FormFacade::class,
        'Html'                => Collective\Html\HtmlFacade::class,
        'Excel'               => Maatwebsite\Excel\Facades\Excel::class,
        'LaravelLocalization' => Mcamara\LaravelLocalization\Facades\LaravelLocalization::class,
        'Hashids'             => Vinkla\Hashids\Facades\Hashids::class,
        'SEOMeta'             => Artesaos\SEOTools\Facades\SEOMeta::class,
        'OpenGraph'           => Artesaos\SEOTools\Facades\OpenGraph::class,
        'Twitter'             => Artesaos\SEOTools\Facades\TwitterCard::class,
        'SEO'                 => Artesaos\SEOTools\Facades\SEOTools::class,
        'Analytics'           => Spatie\Analytics\AnalyticsFacade::class,
        'Crawler'             => Jaybizzle\LaravelCrawlerDetect\Facades\LaravelCrawlerDetect::class,

        'ReCaptcha' => Biscolab\ReCaptcha\Facades\ReCaptcha::class,
        
    ],

];
