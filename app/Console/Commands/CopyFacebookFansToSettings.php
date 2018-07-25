<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Zttp\Zttp;
use App\Models\Settings;

class CopyFacebookFansToSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:facebook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy all the facebook fans to the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $response = Zttp::get('https://graph.facebook.com/bipolar.zapatos/?fields=fan_count&access_token=100210840716931|hxQGZTOgdjwE1zG8tDKwyN7Fvy0');

        $settings = Settings::first();

        if (!$response->isSuccess()) {
            return;
        }

        $settings->facebook_counts = array_get($response->json(), 'fan_count', $settings->facebook_counts);
        $settings->save();
    }
}
