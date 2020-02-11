<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Page;
use App\Screenshot;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Screenshot::class, function (Faker $faker) {
    return [
        'uuid' => (string) Str::uuid(),
        'page_id' => factory(Page::class),
        'src' => $faker->imageUrl(1920, 1080),
    ];
});
