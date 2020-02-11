<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class SignUp extends TestCase
{
    use DatabaseMigrations, MockHttpCalls, WithFaker;

    /** @test */
    public function a_user_can_view_the_sign_up_page()
    {
        $this->get(route('sign-up.index'))
            ->assertSeeText('Pricing')
            ->assertOk();
    }

    /** @test */
    public function a_user_can_sign_up_by_submitting_the_sign_up_form()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'payment_method_id' => 'pm_card_visa',
            'product_id' => 1,
        ];

        $response = $this->post(route('sign-up.store'), $data);

        dd($response);
    }
}
