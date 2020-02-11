<?php

namespace Tests\Feature\Page;

use App\Models\Page;
use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class DeleteTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function a_user_can_only_destroy_a_page_if_they_own_the_website_that_page_is_assigned_to()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->be($user1);
        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id,
        ]);

        $page1 = factory(Page::class)->create([
            'website_id' => $website1->id,
            'route' => '/route1',
        ]);

        $this->be($user2);
        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id,
        ]);

        $page2 = factory(Page::class)->create([
            'website_id' => $website2->id,
            'route' => '/route2',
        ]);

        $this->be($user1);
        $website1->refresh();
        $this->assertCount(1, $website1->pages);

        $this->delete(route('pages.destroy', ['page' => $page1]))
            ->assertStatus(302);

        $website1->refresh();
        $this->assertCount(0, $website1->pages);

        $this->be($user2);
        $website2->refresh();
        $this->assertCount(1, $website2->pages);

        $this->be($user1);

        $this->delete(route('websites.destroy', ['website' => $website2]))
            ->assertStatus(404);

        $this->be($user2);
        $website2->refresh();
        $this->assertCount(1, $website2->pages);
    }
}
