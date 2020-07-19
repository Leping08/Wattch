<?php

namespace Tests\Feature\Assertion;

use App\Models\Assertion;
use App\Models\AssertionResult;
use App\Models\HttpResponse;
use App\Models\Page;
use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RunTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_run_an_assertion_by_hitting_the_endpoint()
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
        ]);

        //Assert no results
        $this->assertCount(1, $assertion->results);

        //Hit the run assertion endpoint
        $this->post(route('assertions.run.index', ['assertion' => $assertion]))
            ->assertStatus(302);

        //Get a fresh instance of the model
        $assertion = Assertion::find($assertion->id)->fresh();

        //Assert at least one result has been added
        $this->assertCount(2, $assertion->results);

    }

    /** @test */
    public function a_user_only_run_assertions_for_websites_they_own()
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

        $this->post(route('assertions.run.index', ['assertion' => $assertion1]))
            ->assertStatus(404);

        $this->post(route('assertions.run.index', ['assertion' => $assertion2]))
            ->assertStatus(302);

        $this->be($user1);

        $this->post(route('assertions.run.index', ['assertion' => $assertion1]))
            ->assertStatus(302);

        $this->post(route('assertions.run.index', ['assertion' => $assertion2]))
            ->assertStatus(404);
    }
}