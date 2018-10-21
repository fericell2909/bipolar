<?php

namespace App\Console\Commands;

use App\Models\HomePost;
use Illuminate\Console\Command;

class HomePostActivation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'home_post:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate all the home posts with begin date';

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
        $homePosts = HomePost::whereNotNull('begin_date')
            ->whereNotIn('state_id', [config('constants.STATE_ACTIVE_ID')])
            ->get();

        $homePosts = $homePosts->filter(function ($homePost) {
            /** @var HomePost $homePost */
            return now()->greaterThanOrEqualTo($homePost->begin_date);
        });

        if ($homePosts->isEmpty()) {
            return;
        }

        HomePost::whereIn('id', $homePosts->pluck('id')->toArray())->update(['state_id' => config('constants.STATE_ACTIVE_ID')]);
    }
}
