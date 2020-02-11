<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

$factory->define(\App\Models\Feature::class, function (Faker $faker) {
    return [
        'product_id' => factory(\App\Models\Product::class),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'rules' => [],
    ];
});
