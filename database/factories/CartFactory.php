<?php

use Faker\Generator as Faker;
use App\Models\Cart;
use App\Models\User;

$factory->define(Cart::class, function (Faker $faker) {
    return [
        'user_id'   => factory(User::class)->create()->id,
        'subtotal'  => $faker->numberBetween(300, 500),
        'total'     => $faker->numberBetween(300, 500),
    ];
});
