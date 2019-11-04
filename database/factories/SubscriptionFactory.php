<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(\App\Subscription::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create()->id,
        'name' => 'prod_' . $faker->lexify('??????????????'),
        'stripe_id' => 'sub_' . $faker->lexify('??????????????'),
        'stripe_status' => 'active',
        'stripe_plan' => 'plan_' . $faker->lexify('??????????????'),
        'quantity' => 1,
        'trial_ends_at' => null,
        'ends_at' => null
    ];
});
