<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Page;
use App\Models\Screenshot;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Screenshot::class, function (Faker $faker) {
    return [
        'uuid' => (string) Str::uuid(),
        'page_id' => factory(Page::class),
        'src' => $faker->imageUrl(1920, 1080),
    ];
});
