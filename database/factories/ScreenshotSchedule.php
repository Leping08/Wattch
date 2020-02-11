<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Page;
use App\Models\ScreenshotSchedule;
use Faker\Generator as Faker;

$factory->define(ScreenshotSchedule::class, function (Faker $faker) {
    return [
        'page_id' => factory(Page::class)->create()->id,
    ];
});
