<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Screenshot;
use App\Page;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Screenshot::class, function (Faker $faker) {
    return [
        'uuid' => (string) Str::uuid(),
        'page_id' => factory(Page::class)->create()->id,
        'src' => $faker->imageUrl(1920, 1080)
    ];
});
