<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearRedisCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rediscache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Clear redis cache if it's filled";

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
        $this->info('Cleaning cache');
        \Cache::flush();
        $this->info('Cache cleaned');
    }
}
