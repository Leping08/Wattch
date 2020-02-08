<?php


namespace Tests\Feature;


use App\AssertionType;
use App\Notifications\AssertionFailed;
use App\User;
use App\UserNotificationChannel;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class NotificationTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_only_uses_active_channels_for_that_user()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $this->assertCount(0, $user->viaNotificationChannels());

        foreach (UserNotificationChannel::all() as $channel) {
            $channel->muted_at = null;
            $channel->save();
        }

        $user->viaNotificationChannels();

        $this->assertCount(2, $user->viaNotificationChannels());

        $channel = UserNotificationChannel::first();
        $channel->muted_at = Carbon::now();
        $channel->save();

        $this->assertCount(1, $user->viaNotificationChannels());


//        $site = factory(Website::class)->create([
//            'user_id' => $user
//        ]);
//
//        $page = $site->pages->first();
//
//        $assertion = factory(Assertion::class)->create([
//            'page_id' => $page->id,
//            'assertion_type_id' => 2,
//            'parameters' => [404]
//        ]);
//
//        Notification::assertNothingSent();
//
//        //This assertion will fail
//        $assertion->execute(); //TODO dont hit a live site in tests
//
//        // Assert a notification was sent to the given user
//        Notification::assertSentTo($user, AssertionFailed::class);


//        Notification::assertSentTo($user, AssertionFailed::class, function ($notification, $channels) use ($user) {
//            $mailData = $notification->toMail($user)->toArray();
//            $slackData = $notification->toSlack($user);
//            dd($slackData);
//        });

//        Notification::assertSentTo(
//            $user,
//            OrderShipped::class,
//            function ($notification, $channels) use ($user){
//                // retrive the mail content
//                $mailData = $notification->toMail($user)->toArray();
//                $this->assertEquals("Order #{$order->orderNumber} shipped", $mailData['subject']);
//                $this->assertEquals("Hello {$user->name}!", $mailData['greeting']);
//                $this->assertContains("Your order #{$order->orderNumber} has been shipped", $mailData['introLines']);
//                $this->assertEquals("View Order", $mailData['actionText']);
//                $this->assertEquals(route('orders.show', $order), $mailData['actionUrl']);
//                $this->assertContains("Thank You!", $mailData['outroLines']);
//                return $notification->order->id === $order->id;
//            }
//        );
    }
}
