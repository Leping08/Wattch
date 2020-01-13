<?php


namespace Tests\Feature\Page;


use App\Assertion;
use App\User;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_must_be_logged_in_to_see_the_details_of_a_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $website->refresh();
        $page = $website->pages->first();

        $this->get(route('pages.show', ['page' => $page]))
            ->assertStatus(200);

        Auth::logout();

        $this->get(route('pages.show', ['page' => $page]))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }


    /** @test */
    public function a_user_can_only_view_a_page_details_for_websites_they_own()
    {
        $user1 = factory(User::class)->create();
        $this->be($user1);

        $user2 = factory(User::class)->create();

        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id
        ]);

        $website1->refresh();
        $page1 = $website1->pages->first();

        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id
        ]);

        $this->be($user2);

        $website2->refresh();
        $page2 = $website2->pages->first();

        $this->be($user1);

        $this->get(route('pages.show', ['page' => $page1]))
            ->assertStatus(200);

        $this->get(route('pages.show', ['page' => $page2]))
            ->assertStatus(404);
    }

    /** @test */
    public function a_user_can_see_the_latest_screenshot_for_the_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $website->refresh();
        $page = $website->pages->first();

        $this->get(route('pages.show', ['page' => $page]))
            ->assertStatus(200)
            ->assertSee($page->screenshots->first()->src);
    }

    /** @test */
    public function a_user_can_see_the_response_time_graph_for_the_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $website->refresh();
        $page = $website->pages->first();

        $this->get(route('pages.show', ['page' => $page]))
            ->assertStatus(200)
            ->assertSeeText('Response Time');
    }

    /** @test */
    public function a_user_can_see_the_assertions_for_the_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $website->refresh();
        $page = $website->pages->first();

        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
            'assertion_type_id' => 1
        ]);

        $this->get(route('pages.show', ['page' => $page]))
            ->assertStatus(200)
            ->assertSeeText('Assertions')
            ->assertSeeText($assertion->type->method);
    }

    /** @test */
    public function a_user_can_see_the_full_route_for_the_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $website->refresh();
        $page = $website->pages->first();


        $this->get(route('pages.show', ['page' => $page]))
            ->assertStatus(200)
            ->assertSeeText($page->full_route);
    }
}