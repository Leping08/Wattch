<?php

namespace Tests\Feature\Page;

use App\Models\HttpResponse;
use App\Models\Page;
use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class IndexTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function a_user_can_only_see_the_page_index_if_they_are_logged_in()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->get(route('pages.index'))
            ->assertStatus(200);

        Auth::logout();

        $this->get(route('pages.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_only_see_the_page_of_a_website_they_own()
    {
        $this->fakeHttpResponse();

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->be($user1);
        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id,
            'domain' => 'http://deltavcreative.com/',
        ]);

        $page1 = factory(Page::class)->create([
            'website_id' => $website1->id,
            'route' => '/website_1_route',
        ]);

        $this->be($user2);
        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id,
            'domain' => 'http://racingvods.com/',
        ]);

        $page2 = factory(Page::class)->create([
            'website_id' => $website2->id,
            'route' => '/website_2_route',
        ]);

        $this->be($user1);

        $this->get(route('websites.show', ['website' => $website1->id]))
            ->assertSeeText('website_1_route')
            ->assertDontSeeText('website_2_route');

        $this->get(route('websites.show', ['website' => $website2->id]))
            ->assertStatus(404);
    }

    /** @test */
    public function a_user_can_see_all_the_pages_for_a_website()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
            'domain' => 'http://deltavcreative.com/',
        ]);

        $page1 = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/route1',
        ]);

        $page2 = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/route2',
        ]);

        $page3 = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/route3',
        ]);

        $this->get(route('websites.show', ['website' => $website->id]))
            ->assertSeeText('route1')
            ->assertSeeText('route2')
            ->assertSeeText('route3');
    }

    /** @test */
    public function a_user_should_see_the_latest_status_code_and_response_time_for_the_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
            'domain' => 'http://deltavcreative.com/',
        ]);

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/route1',
        ]);

        $response = factory(HttpResponse::class)->create([
            'page_id' => $page->id,
            'response_code' => '400',
            'total_time' => '2.78',
        ]);

        $this->get(route('websites.show', ['website' => $website->id]))
            ->assertSeeText('400')
            ->assertSeeText('2.78');
    }
}
