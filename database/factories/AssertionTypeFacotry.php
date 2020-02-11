<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\AssertionType;
use Faker\Generator as Faker;

$factory->define(AssertionType::class, function (Faker $faker) {
    return [
        'name' => 'Assert Status',
        'method' => 'assertStatus',
        'icon' => 'undraw_server_status_5pbv.svg',
        'example' => 200,
        'description' => 'Assert a status code is returned for the page',
    ];
});
