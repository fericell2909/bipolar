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
use App\Console\Commands\CheckProductStock;
use App\Console\Commands\SendBuyReminderEmail;

class Kernel extends ConsoleKernel
{
    private $thirtySecondsAfterMidnight = '00:00:30';

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
        $schedule->command(ExecuteDiscountTasks::class)->dailyAt($this->thirtySecondsAfterMidnight);
        $schedule->command(RevertDiscountTasks::class)->dailyAt($this->thirtySecondsAfterMidnight);
        $schedule->command(CopyFacebookFansToSettings::class)->dailyAt($this->thirtySecondsAfterMidnight);
        $schedule->command(HomePostActivation::class)->hourly();
        $schedule->command(SyncBsaleStocks::class)->everyMinute();
        $schedule->command('sitemap:generate')->weekly();
        $schedule->command(CheckProductStock::class)->dailyAt('03:00:00');
        $schedule->command('activitylog:clean')->daily();
        $schedule->command(SendNoBuyedCarts::class)->hourly();
        $schedule->command(SendBuyReminderEmail::class)->dailyAt('10:30:00');
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
