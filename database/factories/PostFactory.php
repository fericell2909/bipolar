<?php

use Faker\Generator as Faker;
use App\Models\Post;

$factory->define(Post::class, function (Faker $faker) {
    $states = [
        config('constants.STATE_PREVIEW_ID'),
        config('constants.STATE_WAITING_ID'),
        config('constants.STATE_ACTIVE_ID'),
    ];
    $stateIndex = array_rand($states, 1);

    return [
        'title' => [
            'es' => $faker->sentence(4),
            'en' => $faker->sentence(4),
        ],
        'content' => [
            'es' => "{$faker->sentence(30)}",
            'en' => "{$faker->sentence(30)}",
        ],
        'state_id' => $states[$stateIndex],
    ];
});
