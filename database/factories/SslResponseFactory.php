<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\SslResponse;
use App\Models\Website;
use Faker\Generator as Faker;

$factory->define(SslResponse::class, function (Faker $faker) {
    return [
        'website_id' => factory(Website::class),
        'ssl_valid' => true,
        'ssl_expires_in' => $faker->numberBetween(1, 90),
        'ssl_raw' => [],
    ];
});
