<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Feature;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Feature::class, function (Faker $faker) {
    return [
        'product_id' => factory(Product::class),
        'name' => $faker->word,
        'description' => $faker->sentence,
        'rules' => [],
    ];
});
