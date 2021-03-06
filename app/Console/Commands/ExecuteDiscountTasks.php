<?php

namespace App\Console\Commands;

use App\Models\DiscountTask;
use App\Models\Product;
use App\Models\Subtype;
use App\Models\Type;
use Illuminate\Console\Command;

class ExecuteDiscountTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:execute {--discount=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute available tasks';

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
            $discountTasks = DiscountTask::whereDate('begin', '<=', now()->toDateString())
                ->where('end', '>', now()->toDateTimeString())
                ->where('available', true)
                ->where('executed', false)
                ->get();
        }
        if ($discountTasks->isNotEmpty()) {
            \Log::info("Task #ID activating started", $discountTasks->pluck('name', 'id')->toArray());
        }

        $discountTasks->each(function ($discount) {
            /** @var DiscountTask $discount */
            if ($discount->is_2x1) {
                $discount = $this->assign2x1Discount($discount);
            } else {
                $discount = $this->assignCurrencyDiscount($discount);
            }
            $discount->executed = true;
            $discount->save();
        });

        if ($discountTasks->isNotEmpty()) {
            \Log::info("Task #ID activating finished", $discountTasks->pluck('name', 'id')->toArray());
        }
    }

    private function assign2x1Discount(DiscountTask $discount): DiscountTask
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

    private function assignCurrencyDiscount(DiscountTask $discount): DiscountTask
    {
        $mainParams = [
            'discount_pen'   => $discount->discount_pen,
            'discount_usd'   => $discount->discount_usd,
            'begin_discount' => $discount->begin,
            'end_discount'   => $discount->end,
        ];

        if ($discount->product_types) {
            $types = Type::find($discount->product_types);
            foreach ($types as $type) {
                foreach ($type->subtypes as $subtype) {
                    $subtype->products->each($this->productMassiveDiscountUpdate($discount->discount_pen, $discount->discount_usd, $mainParams, false));
                }
            }
        }

        if ($discount->product_subtypes) {
            $subtypes = Subtype::find($discount->product_subtypes);
            foreach ($subtypes as $subtype) {
                $subtype->products->each($this->productMassiveDiscountUpdate($discount->discount_pen, $discount->discount_usd, $mainParams, false));
            }
        }

        if ($discount->products) {
            $products = Product::find($discount->products);
            $products->each($this->productMassiveDiscountUpdate($discount->discount_pen, $discount->discount_usd, $mainParams, false));
        }

        return $discount;
    }

    private function productMassive2x1Update()
    {
        return function ($product) {
            /** @var Product $product */
            return $product->update(['is_deal_2x1' => true]);
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
