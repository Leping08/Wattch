<?php


namespace Tests\Feature\Website;


use App\Assertion;
use App\AssertionResult;
use App\Page;
use App\SslResponse;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_only_see_the_websites_index_if_they_are_logged_in()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $this->get(route('websites.index'))
            ->assertStatus(200)
            ->assertSee('Websites');

        Auth::logout();

        $this->get(route('websites.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_only_see_the_websites_assigned_to_them()
    {
        $user1 = factory(\App\User::class)->create();
        $this->be($user1);

        $user2 = factory(\App\User::class)->create();

        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id,
            'domain' => 'http://deltavcreative.com/'
        ]);

        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id,
            'domain' => 'http://racingvods.com/'
        ]);

        $website3 = factory(Website::class)->create([
            'user_id' => $user1->id,
            'domain' => 'https://theswimschoolfl.com/'
        ]);

        $this->get(route('websites.index'))
            ->assertStatus(200)
            ->assertSee($website1->domain)
            ->assertDontSee($website2->domain)
            ->assertSee($website3->domain);
    }

    /** @test */
    public function a_user_can_see_the_page_count_for_each_website()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $website1 = factory(Website::class)->create([
            'user_id' => $user->id
        ]);
        factory(Page::class, 10)->create([
            'website_id' => $website1->id
        ]);


        $website2 = factory(Website::class)->create([
            'user_id' => $user->id
        ]);
        factory(Page::class, 5)->create([
            'website_id' => $website2->id
        ]);

        $this->get(route('websites.index'))
            ->assertStatus(200)
            ->assertSeeText($website1->pages->count())
            ->assertSee($website2->pages->count());
    }

    /** @test */
    public function a_user_can_see_when_the_ssl_expires_for_a_website()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        factory(SslResponse::class)->create([
            'website_id' => $website->id,
            'ssl_expires_in' => 17
        ]);

        $this->get(route('websites.index'))
            ->assertStatus(200)
            ->assertSeeText(17);
    }

    /** @test */
    public function a_user_can_see_when_the_websites_ssl_is_already_expired_or_was_never_set_up()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        factory(SslResponse::class)->create([
            'website_id' => $website->id,
            'ssl_expires_in' => 0
        ]);

        $this->get(route('websites.index'))
            ->assertStatus(200)
            ->assertSeeText(0)
            ->assertSeeText('expired');
    }

    /** @test */
    public function a_user_can_see_the_latest_screenshot_for_the_homepage_of_the_website()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $this->get(route('websites.index'))
            ->assertStatus(200)
            ->assertSee($website->home_page->latest_screenshot->src);
    }

    /** @test */
    public function a_user_can_see_status_bar_for_a_website()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $page = $website->pages->first();

        $assertion1 = factory(Assertion::class)->create([
            'page_id' => $page->id
        ]);

        $result1 = factory(AssertionResult::class)->create([
            'assertion_id' => $assertion1->id,
            'success' => false
        ]);

        $assertion2 = factory(Assertion::class)->create([
            'page_id' => $page->id
        ]);

        $result2 = factory(AssertionResult::class)->create([
            'assertion_id' => $assertion2->id,
            'success' => true
        ]);

        $this->get(route('websites.index'))
            ->assertStatus(200)
            ->assertSee('width: 50%');
    }
}