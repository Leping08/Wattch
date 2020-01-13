<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Assertion;
use App\AssertionResult;
use Faker\Generator as Faker;

$factory->define(AssertionResult::class, function (Faker $faker) {
    return [
        'assertion_id' => factory(Assertion::class)->create()->id,
        'success' => true,
        'error_message' => '',
    ];
});
