<?php


namespace Tests\Unit\Observers;


use App\User;
use App\UserNotificationChannel;
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
}
