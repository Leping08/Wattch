<?php

namespace Tests\Feature\Page;

use App\Page;
use App\ScreenshotSchedule;
use App\Task;
use App\User;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_only_store_a_page_index_if_they_are_logged_in()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);

        $data = [
            'website_id' => $website->id,
            'route' => '/news',
        ];

        $this->post(route('pages.store', $data))
            ->assertStatus(302)
            ->assertRedirect(route('websites.show', ['website' => $website->id]));

        Auth::logout();

        $this->post(route('pages.store', $data))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_only_store_a_page_for_a_website_they_own()
    {
        $user1 = factory(User::class)->create();
        $this->be($user1);

        $user2 = factory(User::class)->create();

        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id,
        ]);

        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id,
        ]);

        $data1 = [
            'website_id' => $website1->id,
            'route' => '/news',
        ];

        $data2 = [
            'website_id' => $website2->id,
            'route' => '/sports',
        ];

        $website1->refresh();
        $this->assertCount(0, $website1->pages);

        $this->post(route('pages.store', $data1))
            ->assertStatus(302)
            ->assertRedirect(route('websites.show', ['website' => $website1->id]));

        $website1->refresh();
        $this->assertCount(1, $website1->pages);

        $this->post(route('pages.store', $data2))
            ->assertStatus(404);

        $website1->refresh();
        $this->assertCount(1, $website1->pages);
    }

    /** @test */
    public function a_user_can_not_store_the_same_page_twice()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $website->refresh();
        $this->assertCount(1, $website->pages);

        $data = [
            'website_id' => $website->id,
            'route' => '/',
        ];

        $this->post(route('pages.store', $data))
            ->assertStatus(302)
            ->assertRedirect(route('websites.show', ['website' => $website->id]));

        $website->refresh();
        $this->assertCount(1, $website->pages);
    }

    /** @test */
    public function a_screenshot_is_taken_when_the_user_adds_a_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $page->refresh();
        $this->assertCount(1, $page->screenshots);
    }

    /** @test */
    public function a_screenshot_schedule_is_created_when_the_user_adds_a_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $this->assertCount(1, ScreenshotSchedule::all());
    }

    /** @test */
    public function a_screenshot_task_is_created_when_the_user_adds_a_page()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id,
        ]);

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $this->assertCount(1, Task::where([
            'taskable_id' => $page->id,
            'taskable_type' => ScreenshotSchedule::class,
            'frequency' => 'daily',
        ])->get());
    }
}
