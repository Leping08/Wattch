<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(\App\Feature::class, function (Faker $faker) {
    return [
        'product_id' => factory(\App\Product::class)->create()->id,
        'name' => $faker->word,
        'description' => $faker->sentence,
        'rules' => []
    ];
});
