<?php


namespace Tests\Feature\Website;


use App\User;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_only_destroy_a_website_if_they_own_it()
    {
        $user1 = factory(User::class)->create();
        $this->be($user1);
        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id
        ]);

        $user2 = factory(User::class)->create();
        $this->be($user2);
        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id
        ]);

        $this->be($user1);
        $user1->refresh();
        $this->assertCount(1, $user1->websites);

        $this->delete(route('websites.destroy', ['website' => $website1]))
            ->assertStatus(302);

        $user1->refresh();
        $this->assertCount(0, $user1->websites);

        $this->be($user2);
        $user2->refresh();
        $this->assertCount(1, $user2->websites);

        $this->be($user1);

        $this->delete(route('websites.destroy', ['website' => $website2]))
            ->assertStatus(404);

        $this->be($user2);
        $user2->refresh();
        $this->assertCount(1, $user2->websites);
    }

    /** @test */
    public function a_user_can_destroy_a_website_by_hitting_the_website_destroy_route()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $user->refresh();
        $this->assertCount(1, $user->websites);

        $this->delete(route('websites.destroy', ['website' => $website]))
            ->assertStatus(302);

        $user->refresh();
        $this->assertCount(0, $user->websites);
    }
}