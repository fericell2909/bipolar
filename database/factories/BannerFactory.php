<?php

use Faker\Generator as Faker;
use App\Models\Banner;

$factory->define(Banner::class, function (Faker $faker) {
    return [
        'url'        => $faker->imageUrl(1700, 1218, 'city'),
        'state_id'   => $faker->numberBetween(1, 3),
        'begin_date' => now(),
        'end_date'   => now()->addWeek(),
    ];
});

$factory->state(Banner::class, 'active', function (Faker $faker) {
    return [
        'state_id' => config('constants.STATE_ACTIVE_ID'),
    ];
});
