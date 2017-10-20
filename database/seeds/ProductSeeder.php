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
            $p->photos()->save(factory(\App\Models\Photo::class)->make(['product_id' => $p->id]));
        });
    }
}
