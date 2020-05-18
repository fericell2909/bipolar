<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Product::class, 20)->create();
        factory(\App\Models\Product::class, 20)->create()->each(function ($p) {
            /** @var \App\Models\Product $p */
            $p->subtypes()->sync([Arr::random(range(1, 5))]);
            $p->stocks()->saveMany(factory(\App\Models\Stock::class, 3)->make([
                'product_id'    => $p->id,
                'incoming_date' => now(),
                'quantity'      => 999
            ]));
            $p->photos()->saveMany(factory(\App\Models\Photo::class, 3)->make(['product_id' => $p->id]));
        });
    }
}
