<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Page;
use App\Website;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'website_id' => factory(Website::class),
        'route' => '/'.$faker->word,
    ];
});
