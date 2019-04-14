<?php

namespace App\Console\Commands;

use App\Models\HomePost;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Console\Command;

class PublishStuff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:automatic_publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enable automatic backgrounds';

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
        $this->publishBackgrounds();
        $this->publishProducts();
        $this->publishHomePosts();
    }

    private function publishHomePosts()
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

    private function publishProducts()
    {
        $today = now();

        Product::whereNotNull('publish_date')
            ->whereDate('publish_date', $today->toDateString())
            ->whereTime('publish_date', '<=', $today->toTimeString())
            ->whereNotIn('state_id', [config('constants.STATE_ACTIVE_ID')])
            ->update([
                'state_id'     => config('constants.STATE_ACTIVE_ID'),
                'publish_date' => null,
            ]);
    }

    private function publishBackgrounds()
    {
        $today = now();

        $imageToEnable = Image::where('active', false)
            ->whereDate('start_time', $today->toDateString())
            ->whereTime('start_time', '<=', $today->toTimeString())
            ->first();

        if ($imageToEnable) {
            $imageToEnable->active = true;
            $imageToEnable->save();
            Image::whereKeyNot($imageToEnable->id)->update(['active' => false]);
        }
    }
}
