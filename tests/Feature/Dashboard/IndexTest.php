<?php

namespace Tests\Feature\Dashboard;

use App\Models\Assertion;
use App\Models\Page;
use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_only_see_the_dashboard_if_they_are_logged_in()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSee('dashboard');

        Auth::logout();

        $this->get(route('dashboard'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_sees_the_counts_on_the_dashboard()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);

        $pages = factory(Page::class, 10)->create([
            'website_id' => $website->id,
        ]);

        foreach ($pages as $page) {
            factory(Assertion::class)->create([
                'page_id' => $page,
            ]);
        }

        $response = $this->get(route('dashboard'));

        $response->assertSeeText('Websites')
            ->assertSeeText('Assertions')
            ->assertSeeText('Successful Assertions')
            ->assertSeeText('Failed Assertions')
            ->assertSeeText('Alerts')
            ->assertSee(Website::all()->count())
            ->assertSee(Assertion::all()->count());
        //->assertSee(Alert::all()->count())
    }

    /** @test */
    public function a_user_can_see_the_last_5_assertions_on_the_dashboard_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);

        $pages = factory(Page::class, 5)->create([
            'website_id' => $website->id,
        ]);

        foreach ($pages as $page) {
            factory(Assertion::class)->create([
                'page_id' => $page,
            ]);
        }

        $last_5_assertions = Assertion::with('page', 'type')->latest()->take(5)->get();

        $response = $this->get(route('dashboard'));

        foreach ($last_5_assertions as $assertion) {
            $response->assertSeeText($assertion->page->full_route);
            $response->assertSeeText($assertion->type->method);
        }
    }
}
