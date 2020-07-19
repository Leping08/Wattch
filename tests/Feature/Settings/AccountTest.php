<?php

namespace Tests\Feature\Settings;

use App\Models\Product;
use App\Models\User;
use App\Subscription;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_change_their_user_name_and_email()
    {
        $user = factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'test@test.com'
        ]);

        $this->actingAs($user);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email
        ]);

        $data = [
            'name' => 'Test Name',
            'email' => 'new@new.com',
            'plan_id' => 1
        ];

        $this->post(route('settings.account.store'), $data);

        $this->assertDatabaseHas('users', [
            'name' => $data['name'],
            'email' => $data['email']
        ]);
    }

    /** @test */
    public function a_user_can_change_the_product_they_are_on()
    {
        $this->seed();

        $user = factory(User::class)->create([
            'name' => 'John Doe',
            'email' => 'test@test.com'
        ]);

        $subscription = factory(Subscription::class)->create([
            'user_id' => $user->id,
            'stripe_plan' => 'plan_Fv1JRE0rl9ig2O' //Pro Plan
        ]);

        //TODO: Set this up
    }
}
