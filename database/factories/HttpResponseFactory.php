<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HttpResponse;
use App\Page;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(HttpResponse::class, function (Faker $faker) {

    //$page = factory(Page::class)->create();

    return [
        'page_id' => factory(Page::class)->create()->id,
        'domain' => $faker->url,
        'response_code' => 200,
        'ip' => $faker->ipv4,
        'total_time' => $faker->numerify('#.##'),
        'headers_raw' => [],
        'request_stats_raw' => []
    ];
});
