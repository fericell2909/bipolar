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
    protected $signature = 'homepost:activate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable/Disable all the home posts';

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
        $homePostsToEnable = HomePost::whereNotNull('begin_date')
            ->whereNotIn('state_id', [config('constants.STATE_ACTIVE_ID')])
            ->get();

        $homePostsToEnable = $homePostsToEnable->filter(function ($homePost) {
            /** @var HomePost $homePost */
            if ($homePost->end_date) {
                return now()->between($homePost->begin_date, $homePost->end_date);
            }

            return now()->greaterThanOrEqualTo($homePost->begin_date);
        });

        if ($homePostsToEnable->isNotEmpty()) {
            HomePost::whereIn('id', $homePostsToEnable->pluck('id')->toArray())->update(['state_id' => config('constants.STATE_ACTIVE_ID')]);
        }

        $homePostToDisable = HomePost::whereNotNull('end_date')
            ->whereIn('state_id', [config('constants.STATE_ACTIVE_ID')])
            ->get();

        $homePostToDisable = $homePostToDisable->filter(function ($homePost) {
            /** @var HomePost $homePost */

            return now()->greaterThanOrEqualTo($homePost->end_date);
        });

        if ($homePostToDisable->isNotEmpty()) {
            HomePost::whereIn('id', $homePostToDisable->pluck('id')->toArray())->update(['state_id' => config('constants.STATE_PREVIEW_ID')]);
        }
    }
}
