<?php

namespace App\Console;

use App\Console\Commands\ExecuteDiscountTasks;
use App\Console\Commands\RevertDiscountTasks;
use App\Console\Commands\SendNoBuyedCarts;
use App\Console\Commands\SyncBsaleStocks;
use App\Console\Commands\CopyFacebookFansToSettings;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(ExecuteDiscountTasks::class)->daily();
        $schedule->command(RevertDiscountTasks::class)->daily();
        $schedule->command(SendNoBuyedCarts::class)->daily();
        $schedule->command(CopyFacebookFansToSettings::class)->daily();
        $schedule->command(SyncBsaleStocks::class)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
