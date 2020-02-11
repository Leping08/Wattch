<?php

namespace Tests\Unit\Models;

use App\Models\Feature;
use App\Models\Product;
use App\Subscription;
use App\Models\User;
use App\Models\Website;
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

        $user = factory(User::class)->create();
        $this->be($user);

        $site = factory(Website::class)->create([
            'user_id' => $user,
        ]);

        $site2 = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);

        foreach ($user->websites as $site) {
            $this->assertInstanceOf(Website::class, $site);
        }
    }

    /** @test */
    public function it_has_a_subscription()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $subscription = factory(Subscription::class)->create([
            'user_id' => $user->id,
        ]);

        $this->assertInstanceOf(Subscription::class, $user->subscription);
    }

    /* @test */   /* TODO: Fix this test */
//    public function it_has_a_product_through_a_subscription()
//    {
//        $user = factory(User::class)->create();
//
//        $subscription = factory(Subscription::class)->create([
//            'user_id' => $user->id,
//            'stripe_plan' => 'plan_yeettest'
//        ]);
//
//        $product = factory(Product::class)->create([
//            'name' => 'Test',
//            'stripe_plan' => 'plan_yeettest'
//        ]);
//
//        $this->assertInstanceOf(Product::class, $user->product());
//    }

    /* @test */   /* TODO: Fix this test */
//    public function it_has_a_features_through_a_product()
//    {
//        $user = factory(User::class)->create();
//
//        $subscription = factory(Subscription::class)->create([
//            'user_id' => $user->id,
//            'stripe_plan' => 'plan_yeettest'
//        ]);
//
//        $product = factory(Product::class)->create([
//            'name' => 'Test',
//            'stripe_plan' => 'plan_yeettest'
//        ]);
//
//        $feature1 = factory(Feature::class)->create([
//            'product_id' => $product->id
//        ]);
//
//        $feature2 = factory(Feature::class)->create([
//            'product_id' => $product->id
//        ]);
//
//        foreach ($user->features() as $feature) {
//            $this->assertInstanceOf(Feature::class, $feature);
//        }
//    }
}
