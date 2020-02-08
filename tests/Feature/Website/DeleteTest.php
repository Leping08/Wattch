<?php


namespace Tests\Feature\Website;


use App\User;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class DeleteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_only_destroy_a_website_if_they_own_it()
    {
        $user1 = factory(User::class)->create();
        $this->be($user1);

        $user2 = factory(User::class)->create();

        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id
        ]);

        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id
        ]);

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
}