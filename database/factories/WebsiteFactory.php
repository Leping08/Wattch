<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use App\Models\Website;
use Faker\Generator as Faker;

$factory->define(Website::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class),
        'domain' => config('website.test_site'),
    ];
});
