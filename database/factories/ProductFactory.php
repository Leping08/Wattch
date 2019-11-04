<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'stripe_plan' => factory(\App\Subscription::class)->create()->stripe_plan
    ];
});

