<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\HomePost::class, function (Faker $faker) {
    return [
        'post_type_id'     => function () {
            return factory(\App\Models\PostType::class)->create()->id;
        },
        'state_id'         => $faker->numberBetween(1, 3),
        'name'             => $faker->word,
        'redirection_link' => $faker->optional()->url,
    ];
});
