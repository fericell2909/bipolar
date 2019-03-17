<?php

namespace App\Console\Commands;

use App\Models\Image;
use Illuminate\Console\Command;

class AutomaticBackgrounds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:automatic_backgrounds';

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
        $today = now()->startOfHour();

        $imageToEnable = Image::whereDate('start_time', $today->toDateString())
            ->whereTime('start_time', '>=', $today->toTimeString())
            ->whereTime('start_time', '<=', $today->copy()->endOfHour()->toTimeString())
            ->where('active', false)
            ->first();

        if ($imageToEnable) {
            $imageToEnable->active = true;
            $imageToEnable->save();
        }

        Image::whereKeyNot($imageToEnable->id)->update(['active' => false]);
    }
}
