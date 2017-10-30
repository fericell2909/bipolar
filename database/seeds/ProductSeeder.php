<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Product::class, 20)->create(['active' => null]);
        factory(\App\Models\Product::class, 20)->create(['active' => now()])->each(function ($p) {
            /** @var \App\Models\Product $p */
            $p->subtypes()->sync([array_random(range(1, 5))]);
            $p->stocks()->saveMany(factory(\App\Models\Stock::class, 3)->make(['product_id' => $p->id]));
            $p->photos()->saveMany(factory(\App\Models\Photo::class, 3)->make(['product_id' => $p->id]));
        });
    }
}
