<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Feature;
use App\Product;

$factory->define(Feature::class, function (Faker $faker) {
    return [
        'product_id' => factory(Product::class),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'rules' => []
    ];
});
