<?php

namespace Tests\Feature\Page;

use App\Models\Page;
use App\Models\Screenshot;
use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_only_see_the_screenshot_for_a_page_that_is_owned_by_a_website_they_own()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->be($user1);
        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id
        ]);
        $page1 = factory(Page::class)->create([
            'website_id' => $website1->id
        ]);
        $screenshot1 = factory(Screenshot::class)->create([
            'page_id' => $page1->id
        ]);

        $this->get(route('screenshots.show', ['screenshot' => $screenshot1]))
            ->assertStatus(200)
            ->assertSee($screenshot1->src);

        $this->be($user2);
        $this->get(route('screenshots.show', ['screenshot' => $screenshot1]))
            ->assertStatus(404);


        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id
        ]);
        $page2 = factory(Page::class)->create([
            'website_id' => $website2->id
        ]);
        $screenshot2 = factory(Screenshot::class)->create([
            'page_id' => $page2->id
        ]);

        $this->get(route('screenshots.show', ['screenshot' => $screenshot2]))
            ->assertStatus(200)
            ->assertSee($screenshot2->src);

        $this->be($user1);
        $this->get(route('screenshots.show', ['screenshot' => $screenshot2]))
            ->assertStatus(404);
    }

    /** @test */
    public function a_user_can_see_a_seceenshot()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $screenshot = factory(Screenshot::class)->create([
            'page_id' => $page->id
        ]);

        $this->get(route('screenshots.show', ['screenshot' => $screenshot]))
            ->assertStatus(200)
            ->assertSee($screenshot->src);
    }
}