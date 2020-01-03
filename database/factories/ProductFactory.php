<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use App\Subscription;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->numberBetween(1000, 5000),
        'stripe_plan' => factory(Subscription::class)->create()->stripe_plan
    ];
});

