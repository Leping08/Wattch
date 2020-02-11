<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Page;
use App\Models\Website;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'website_id' => factory(Website::class),
        'route' => '/'.$faker->word,
    ];
});
