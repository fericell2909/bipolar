<?php

namespace App\Console\Commands;

use App\Models\Stock;
use Illuminate\Console\Command;

class MoveBsaleStockToNewFormat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:bsale_new_format';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DELETE THIS AFTER EXECUTE. Move bsale to new format';

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
        $stocks = Stock::whereNotNull('bsale_stock_id')->get();

        $stocks->each(function ($stock) {
            /** @var Stock $stock */
            $stock->bsale_stock_ids = [$stock->bsale_stock_id];
            $stock->save();
        });

        $this->info('Done');
    }
}
