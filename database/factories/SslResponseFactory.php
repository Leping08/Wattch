<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SslResponse;
use App\Website;
use Faker\Generator as Faker;

$factory->define(SslResponse::class, function (Faker $faker) {
    return [
        'website_id' => factory(Website::class)->create()->id,
        'ssl_valid' => true,
        'ssl_expires_in' => $faker->numberBetween(1, 90),
        'ssl_raw' => []
    ];
});
