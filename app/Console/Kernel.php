<?php

namespace App\Console;

use App\Console\Commands\ExecuteDiscountTasks;
use App\Console\Commands\HomePostActivation;
use App\Console\Commands\RevertDiscountTasks;
use App\Console\Commands\SendNoBuyedCarts;
use App\Console\Commands\SyncBsaleStocks;
use App\Console\Commands\CopyFacebookFansToSettings;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    private $tenMinutesAfterMidnight = '00:10';

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
        $schedule->command(ExecuteDiscountTasks::class)->dailyAt($this->tenMinutesAfterMidnight);
        $schedule->command(RevertDiscountTasks::class)->dailyAt($this->tenMinutesAfterMidnight);
        $schedule->command(CopyFacebookFansToSettings::class)->dailyAt($this->tenMinutesAfterMidnight);
        $schedule->command(HomePostActivation::class)->hourly();
        $schedule->command(SyncBsaleStocks::class)->everyMinute();
        $schedule->command('sitemap:generate')->weekly();
        //$schedule->command(SendNoBuyedCarts::class)->daily();
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
