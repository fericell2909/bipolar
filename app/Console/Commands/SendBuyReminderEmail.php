<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Buy;
use App\Mail\BuyReminderToBipolar;

class SendBuyReminderEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:buy_reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email reminder to Bipolar';

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
        $yesterday = now()->subDay();

        $buys = Buy::otherCurrentStatus([
            config('constants.BUY_SENT_STATUS'),
            config('constants.BUY_TRANSIT_STATUS'),
            config('constants.BUY_CULMINATED_STATUS'),
            config('constants.BUY_PICKUP_STATUS'),
        ])
            ->whereDate('created_at', $yesterday->toDateString())
            ->get();


        if ($buys->isEmpty()) {
            return null;
        }

        $buys->each(function ($buy) {
            /** @var Buy $buy */
            \Mail::to('shop@bipolar.com.pe')->send(new BuyReminderToBipolar($buy));
        });

        \Log::channel('single')->debug("Mail recordatorio: Se enviaron {$buys->count()} correos");
    }
}
