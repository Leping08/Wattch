<?php


namespace Tests\Feature\Website;


use App\HttpResponse;
use App\Page;
use App\User;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class ShowTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function a_user_must_be_logged_in_to_see_the_details_of_a_website()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->fakeHttpResponse();

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $this->get(route('websites.show', ['website' => $website]))
            ->assertStatus(200);

        Auth::logout();

        $this->get(route('websites.show', ['website' => $website]))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_only_view_a_website_if_they_are_the_owner()
    {
        $user1 = factory(User::class)->create();
        $this->be($user1);

        $this->fakeHttpResponse();

        $website = factory(Website::class)->create([
            'user_id' => $user1->id
        ]);

        $this->get(route('websites.show', ['website' => $website]))
            ->assertStatus(200);

        $user2 = factory(User::class)->create();
        $this->be($user2);

        $this->get(route('websites.show', ['website' => $website]))
            ->assertStatus(404);
    }

    /** @test */
    public function a_user_only_see_pages_for_that_website()
    {
        $user1 = factory(User::class)->create();
        $this->be($user1);

        $this->fakeHttpResponse();

        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id
        ]);

        $website2 = factory(Website::class)->create([
            'user_id' => $user1->id
        ]);

        $page1 = factory(Page::class)->create([
            'website_id' => $website1->id,
            'route' => '/page1'
        ]);

        $page2 = factory(Page::class)->create([
            'website_id' => $website2->id,
            'route' => '/page2'
        ]);

        $this->get(route('websites.show', ['website' => $website1]))
            ->assertStatus(200)
            ->assertSee('/page1')
            ->assertDontSee('/page2');

        $this->get(route('websites.show', ['website' => $website2]))
            ->assertStatus(200)
            ->assertSee('/page2')
            ->assertDontSee('/page1');
    }

    /** @test */
    public function a_user_can_see_the_latest_http_response_code_and_response_time_for_the_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->fakeHttpResponse();

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $page = $website->pages->first();

        $response = factory(HttpResponse::class)->create([
            'page_id' => $page->id,
            'total_time' => 2.75
        ]);

        $this->get(route('websites.show', ['website' => $website]))
            ->assertStatus(200)
            ->assertSeeText($response->response_code)
            ->assertSeeText($response->total_time);
    }

    /** @test */
    public function a_user_can_see_the_route_for_the_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->fakeHttpResponse();

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $page = $website->pages->first();

        $this->get(route('websites.show', ['website' => $website]))
            ->assertStatus(200)
            ->assertSeeText($page->route);
    }
}