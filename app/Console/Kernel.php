<?php

namespace App\Console;

use App\Console\Commands\ClearRedisCache;
use App\Console\Commands\PublishStuff;
use App\Console\Commands\ExecuteDiscountTasks;
use App\Console\Commands\RevertDiscountTasks;
use App\Console\Commands\SendNoBuyedCarts;
use App\Console\Commands\CopyFacebookFansToSettings;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CheckProductStock;
use App\Console\Commands\SendBuyReminderEmail;

class Kernel extends ConsoleKernel
{
    private $oneMinuteBeforeMidnight = '23:59';

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
        $schedule->command(RevertDiscountTasks::class)->dailyAt($this->oneMinuteBeforeMidnight);
        $schedule->command(CopyFacebookFansToSettings::class)->daily();
        $schedule->command(PublishStuff::class)->everyMinute()->withoutOverlapping();
        $schedule->command('sitemap:generate')->weekly();
        $schedule->command('activitylog:clean')->daily();
        $schedule->command(SendNoBuyedCarts::class)->hourly();
        $schedule->command(SendBuyReminderEmail::class)->dailyAt('10:30:00');
        $schedule->command('horizon:snapshot')->everyFiveMinutes();
        $schedule->command(ClearRedisCache::class)->quarterly();
        $schedule->command('telescope:prune')->monthly();
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
