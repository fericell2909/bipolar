<?php

namespace App\Console\Commands;

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
            $photo->url = str_replace('https://s3.amazonaws.com/bipolar-peru', env('APP_URL') . '/bipolar-images', $photo->url);
            $photo->save();
        });

        $this->info('Changed');
    }
}
