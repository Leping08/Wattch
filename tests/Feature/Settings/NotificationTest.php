<?php

namespace Tests\Feature\Settings;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_update_their_notification_settings_by_using_the_notifications_settings_form()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $user = User::first();
        $this->assertEquals($user->notificationEmailAddress(), $user->email);
        $this->assertEquals($user->slackWebhookUrl(), null);
        $this->assertTrue($user->getNotificationChannel('slack')->muted);
        $this->assertTrue($user->getNotificationChannel('mail')->muted);

        $data = [
            'email' => 'change@me.io',
            'email_toggle' => true,
            'slack_webhook' => 'https://hooks.slack.com/services/fdsfdsfdsfefsfds',
            'slack_toggle' => true,
        ];

        $response = $this->json('POST', route('settings.notifications.store'), $data);

        $user->fresh();

        $this->assertEquals($user->notificationEmailAddress(), 'change@me.io');
        $this->assertEquals($user->slackWebhookUrl(), 'https://hooks.slack.com/services/fdsfdsfdsfefsfds');
        $this->assertFalse($user->getNotificationChannel('slack')->muted);
        $this->assertFalse($user->getNotificationChannel('mail')->muted);
    }
}
