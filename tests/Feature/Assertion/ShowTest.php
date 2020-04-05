<?php

namespace Tests\Feature\Assertion;

use App\Models\Assertion;
use App\Models\HttpResponse;
use App\Models\Page;
use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_only_see_assertions_for_websites_they_own()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->be($user1);
        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id,
        ]);
        $page1 = factory(Page::class)->create([
            'website_id' => $website1->id,
        ]);
        $assertion1 = factory(Assertion::class)->create([
            'page_id' => $page1->id,
        ]);

        $this->get(route('assertions.show', ['assertion' => $assertion1]))
            ->assertStatus(200);

        $this->be($user2);
        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id,
        ]);
        $page2 = factory(Page::class)->create([
            'website_id' => $website2->id,
        ]);
        $assertion2 = factory(Assertion::class)->create([
            'page_id' => $page2->id,
        ]);

        $this->get(route('assertions.show', ['assertion' => $assertion2]))
            ->assertStatus(200);

        $this->get(route('assertions.show', ['assertion' => $assertion1]))
            ->assertStatus(404);

        $this->be($user1);

        $this->get(route('assertions.show', ['assertion' => $assertion1]))
            ->assertStatus(200);

        $this->get(route('assertions.show', ['assertion' => $assertion2]))
            ->assertStatus(404);
    }

    /** @test */
    public function a_user_can_see_the_page_details_for_the_assertion()
    {
        $user = factory(User::class)->create();

        $this->be($user);
        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);
        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);
        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
            'muted_at' => null,
            'assertion_type_id' => 1,
        ]);

        $response = $this->get(route('assertions.show', ['assertion' => $assertion]));

        $response->assertStatus(200)
            ->assertSee($page->full_route)
            ->assertSee('Active')
            ->assertSee('assertSee');
    }

    /** @test */
    public function a_user_can_see_the_latest_http_response_details_for_the_assertion()
    {
        $user = factory(User::class)->create();

        $this->be($user);
        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);
        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);
        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
            'muted_at' => null,
            'assertion_type_id' => 1,
        ]);

        $http_response = factory(HttpResponse::class)->create([
            'page_id' => $page->id,
            'response_code' => 6969,
            'domain' => 'http://test.com/testing',
            'ip' => '54.92.167.62',
            'total_time' => 0.69,
        ]);

        $page->refresh();

        $response = $this->get(route('assertions.show', ['assertion' => $assertion]));

        $response->assertStatus(200)
            ->assertSee($http_response->total_time)
            ->assertSee($http_response->response_code)
            ->assertSee($http_response->ip);
    }
}
