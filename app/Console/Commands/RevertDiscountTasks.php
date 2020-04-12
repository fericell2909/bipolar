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
            $discountTasks = DiscountTask::whereDate('end', '=', now()->toDateString())
                ->where('available', true)
                ->where('executed', true)
                ->get();
        }
        if ($discountTasks->isNotEmpty()) {
            \Log::info("Task #ID reverting started", $discountTasks->pluck('name', 'id')->toArray());
        }

        $discountTasks->each(function ($discount) {
            /** @var DiscountTask $discount */
            if ($discount->is_2x1) {
                $discount = $this->remove2x1Discount($discount);
            } else {
                $discount = $this->removeCurrencyDiscount($discount);
            }
            $discount->executed = false;
            $discount->save();
        });

        if ($discountTasks->isNotEmpty()) {
            \Log::info("Task #ID reverting finished", $discountTasks->pluck('name', 'id')->toArray());
        }
    }

    private function remove2x1Discount(DiscountTask $discount): DiscountTask
    {
        if ($discount->product_types) {
            $types = Type::find($discount->product_types);
            foreach ($types as $type) {
                foreach ($type->subtypes as $subtype) {
                    $subtype->products->each($this->productMassive2x1Update());
                }
            }
        }

        if ($discount->product_subtypes) {
            $subtypes = Subtype::find($discount->product_subtypes);
            foreach ($subtypes as $subtype) {
                $subtype->products->each($this->productMassive2x1Update());
            }
        }

        if ($discount->products) {
            $products = Product::find($discount->products);
            $products->each($this->productMassive2x1Update());
        }

        return $discount;
    }

    private function removeCurrencyDiscount(DiscountTask $discount): DiscountTask
    {
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
                    $subtype->products->each($this->productMassiveDiscountUpdate(0, 0, $mainParams, true));
                }
            }
        }

        if ($discount->product_subtypes) {
            $subtypes = Subtype::find($discount->product_subtypes);
            foreach ($subtypes as $subtype) {
                $subtype->products->each($this->productMassiveDiscountUpdate(0, 0, $mainParams, true));
            }
        }

        if ($discount->products) {
            $products = Product::find($discount->products);
            $products->each($this->productMassiveDiscountUpdate(0, 0, $mainParams, true));
        }

        return $discount;
    }

    private function productMassive2x1Update()
    {
        return function ($product) {
            /** @var Product $product */
            return $product->update(['is_deal_2x1' => false]);
        };
    }

    private function productMassiveDiscountUpdate($discountPEN, $discountUSD, $mainParams, $convertToNull)
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
