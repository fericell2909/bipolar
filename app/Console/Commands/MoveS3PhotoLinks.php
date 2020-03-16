<?php

namespace App\Console\Commands;

use App\Models\Banner;
use App\Models\Historic;
use Illuminate\Console\Command;
use App\Models\Photo;

class MoveS3PhotoLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bipolar:migrate-from-s3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move the S3 images to the Bipolar server';

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
        $photos = Photo::whereNotNull('url')->get();

        $photos->each(function ($photo) {
            $photo->url = str_replace('https://s3.amazonaws.com/bipolar-peru', config('app.env') . '/storage/bipolar-images', $photo->url);
            $photo->save();
        });

        $banners = Banner::all();

        $banners->each(function ($banner) {
            $banner->url = str_replace('https://s3.amazonaws.com/bipolar-peru', config('app.env') . '/storage/bipolar-images', $banner->url);
            $banner->save();
        });

        $historics = Historic::all();

        $historics->each(function ($historic) {
            $historic->photo = str_replace('https://s3.amazonaws.com/bipolar-peru', config('app.env') . '/storage/bipolar-images', $historic->photo);
            $historic->save();
        });

        $this->info('Changed');
    }
}
