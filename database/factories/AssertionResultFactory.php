<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Assertion;
use App\Models\AssertionResult;
use Faker\Generator as Faker;

$factory->define(AssertionResult::class, function (Faker $faker) {
    return [
        'assertion_id' => factory(Assertion::class),
        'success' => true,
        'error_message' => '',
    ];
});
