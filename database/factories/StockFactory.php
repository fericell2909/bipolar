<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\Models\Stock::class, function (Faker $faker) {
    return [
        'product_id'    => \App\Models\Product::findOrNew($faker->numberBetween(1, 5)),
        'size_id'       => function () use ($faker) {
            if ($faker->boolean() === true) {
                return \App\Models\Size::findOrNew($faker->numberBetween(1, 5));
            }

            return null;
        },
        'incoming_date' => $faker->date(),
        'quantity'      => $faker->numberBetween(1, 100),
        'active'        => $faker->optional()->dateTime(),
    ];
});
