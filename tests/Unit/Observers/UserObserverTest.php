<?php

namespace Tests\Unit\Observers;

use App\Models\User;
use App\Models\UserNotificationChannel;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserObserverTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function created_it_should_generate_notification_settings()
    {
        $this->assertEquals(0, UserNotificationChannel::all()->count());

        $user = factory(User::class)->create();
        $this->be($user);

        $this->assertEquals(2, UserNotificationChannel::all()->count());
    }

    /** @test */
    public function deleted_it_should_delete_all_the_notification_settings_for_a_user()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->assertEquals(2, UserNotificationChannel::all()->count());

        $user->delete();

        $this->assertEquals(0, UserNotificationChannel::all()->count());
    }

    /** @test */
    public function deleted_it_should_delete_websites_owned_by_that_user()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        factory(Website::class, 3)->create([
            'user_id' => $user->id,
        ]);

        $user->refresh();

        $this->assertCount(3, $user->websites);
        $this->assertCount(3, Website::all());

        $user->delete();

        $this->assertCount(0, Website::all());
    }
}
