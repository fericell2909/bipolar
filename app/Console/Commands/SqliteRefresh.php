<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SqliteRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sqlite:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Testing] Refresh Sqlite testing DB';

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
        $this->call('migrate:refresh', ['--database' => 'sqlite']);
        $this->call('db:seed', ['--database' => 'sqlite']);
    }
}
