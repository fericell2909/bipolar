<?php

namespace App\Console\Commands;

use App\Models\DiscountTask;
use App\Models\Product;
use App\Models\Subtype;
use App\Models\Type;
use Illuminate\Console\Command;

class RevertDiscountTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:revert {--discount=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revert all tasks';

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
        if ($this->option('discount')) {
            $discountTasks = DiscountTask::whereKey($this->option('discount'))->get();
        } else {
            $discountTasks = DiscountTask::whereDate('end', '<', now()->toDateString())
                ->where('available', true)
                ->where('executed', true)
                ->get();
        }

        $discountTasks->each(function ($discount) {
            /** @var DiscountTask $discount */
            $mainParams = [
                'discount_pen'   => null,
                'discount_usd'   => null,
                'begin_discount' => null,
                'end_discount'   => null,
            ];

            if ($discount->product_types) {
                $types = Type::find($discount->product_types);
                foreach ($types as $type) {
                    foreach ($type->subtypes as $subtype) {
                        $subtype->products->each($this->assignMassiveDiscount(0, 0, $mainParams, true));
                    }
                }
            }

            if ($discount->product_subtypes) {
                $subtypes = Subtype::find($discount->product_subtypes);
                foreach ($subtypes as $subtype) {
                    $subtype->products->each($this->assignMassiveDiscount(0, 0, $mainParams, true));
                }
            }

            if ($discount->products) {
                $products = Product::find($discount->products);
                $products->each($this->assignMassiveDiscount(0, 0, $mainParams, true));
            }

            $discount->executed = false;
            $discount->save();
        });

        $this->info('Task completed');
    }

    private function assignMassiveDiscount($discountPEN, $discountUSD, $mainParams, $convertToNull)
    {
        return function ($product) use ($discountPEN, $discountUSD, $mainParams, $convertToNull) {
            /** @var Product $product */
            $specificParams = [
                'price_pen_discount' => $convertToNull ? null : $product->price - calculate_percentage($product->price, $discountPEN),
                'price_usd_discount' => $convertToNull ? null : $product->price_dolar - calculate_percentage($product->price_dolar, $discountUSD),
            ];

            $updateParams = array_merge($mainParams, $specificParams);

            $product->update($updateParams);
        };
    }
}
