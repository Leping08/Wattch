<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class UserTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_has_many_websites()
    {
        $this->fakeHttpResponse();

        $user = factory(\App\User::class)->create();

        $site = factory(\App\Website::class)->create([
            'user_id' => $user->id
        ]);

        $site2 = factory(\App\Website::class)->create([
            'user_id' => $user->id
        ]);

        foreach ($user->websites as $site) {
            $this->assertInstanceOf(\App\Website::class, $site);
        }
    }

    /** @test */
    public function it_has_a_subscription()
    {
        $user = factory(\App\User::class)->create();

        $subscription = factory(\App\Subscription::class)->create([
            'user_id' => $user->id
        ]);

        $this->assertInstanceOf(\App\Subscription::class, $user->subscription);
    }

    /** @test */
    public function it_has_a_product_through_a_subscription()
    {
        $user = factory(\App\User::class)->create();

        $subscription = factory(\App\Subscription::class)->create([
            'user_id' => $user->id,
            'stripe_plan' => 'plan_yeettest'
        ]);

        $product = factory(\App\Product::class)->create([
            'name' => 'Test',
            'stripe_plan' => 'plan_yeettest'
        ]);

        $this->assertInstanceOf(\App\Product::class, $user->product());
    }

    /** @test */
    public function it_has_a_features_through_a_product()
    {
        $user = factory(\App\User::class)->create();

        $subscription = factory(\App\Subscription::class)->create([
            'user_id' => $user->id,
            'stripe_plan' => 'plan_yeettest'
        ]);

        $product = factory(\App\Product::class)->create([
            'name' => 'Test',
            'stripe_plan' => 'plan_yeettest'
        ]);

        $feature1 = factory(\App\Feature::class)->create([
            'product_id' => $product->id
        ]);

        $feature2 = factory(\App\Feature::class)->create([
            'product_id' => $product->id
        ]);

        foreach ($user->features() as $feature) {
            $this->assertInstanceOf(\App\Feature::class, $feature);
        }
    }
}
