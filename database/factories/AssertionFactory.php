<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Page;
use App\Assertion;
use App\AssertionType;
use Faker\Generator as Faker;

$factory->define(Assertion::class, function (Faker $faker) {
    return [
        'page_id' => factory(Page::class),
        'assertion_type_id' => factory(AssertionType::class),
        'parameters' => [200],
        'muted_at' => null
    ];
});
