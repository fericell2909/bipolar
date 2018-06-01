<?php

use Faker\Generator as Faker;
use App\Models\Buy;
use App\Models\User;
use App\Models\Address;
use App\Models\Coupon;

$factory->define(Buy::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $address = factory(Address::class)->create(['user_id' => $user->id]);

    return [
        'user_id' => $user->id,
        'coupon_id' => factory(Coupon::class)->create()->id,
        'billing_address_id' => $address->id,
        'shipping_address_id' => $address->id,
        'buy_number' => $faker->numberBetween(1, 1000),
        'subtotal' => $faker->randomFloat(2, 10, 900),
        'shipping_fee' => $faker->randomFloat(2, 10, 900),
        'total' => $faker->randomFloat(2, 10, 900),
        'currency' => $faker->randomElement(['PEN', 'USD']),
        'payed' => optional($faker->optional()->dateTime)->format('Y-m-d H:i:s'),
        'showroom' => $faker->boolean,
    ];
});
