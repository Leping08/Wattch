<?php


namespace Tests\Feature\Website;


use App\User;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_add_a_website_by_hitting_the_website_store_route()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->assertCount(0, $user->websites);

        $data = [
            'website' => 'https://www.google.com/'
        ];

        $this->post(route('websites.store'), $data)
            ->assertRedirect(route('websites.index'));

        $user->refresh();

        $this->assertCount(1, $user->websites);
    }

    /** @test */
    public function a_user_will_get_feedback_when_the_website_is_invalid()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->assertCount(0, Website::all());

        $this->get(route('websites.index'))
            ->assertOk();

        $this->assertCount(0, Website::all());

        $data = [
            'website' => 'bad website url'
        ];

        $this->post(route('websites.store'), $data)
            ->assertRedirect('websites#new-website')
            ->assertSessionHasErrors(['website']);

        $this->assertCount(0, Website::all());
    }

    /** @test */
    public function a_can_not_add_the_same_website_twice()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $data = [
            'user_id' => $user,
            'website' => 'https://wattch.io/'
        ];

        $this->post(route('websites.store'), $data)
            ->assertRedirect(route('websites.index'));

        $user->refresh();

        $this->assertCount(1, $user->websites);

        $this->get(route('websites.index'));

        $this->post(route('websites.store'), $data)
            ->assertRedirect('websites#new-website')
            ->assertSessionHasErrors(['website']);

        $user->refresh();

        $this->assertCount(1, $user->websites);
    }
}