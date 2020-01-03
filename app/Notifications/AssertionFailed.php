<?php

namespace App\Notifications;

use App\AssertionResult;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class AssertionFailed extends Notification
{
    use Queueable;

    protected $assertionResult;


    /**
     * AssertionFailed constructor.
     * @param AssertionResult $assertionResult
     */
    public function __construct(AssertionResult $assertionResult)
    {
        $this->assertionResult = $assertionResult;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = collect();

        //This is the default channel for all notifications
        $channels->push('database');

        //Get the user specific notification channels
        $merged = $channels->merge($this->assertionResult->assertion->user()->viaNotificationChannels());

        return $merged->toArray();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Wattch Assertion Failed')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return SlackMessage
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->content('One of your assertions has failed!')
            ->attachment(function ($attachment) {
                $attachment->title('Assertion details', route('results.show', ['result' => $this->assertionResult]))
                    ->fields([
                        'Assertion' => $this->assertionResult->assertion->type->method,
                        'Page' => $this->assertionResult->assertion->page->full_route,
                        'Message' => $this->assertionResult->error_message
                    ]);
            })
            ->warning();
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->assertionResult->error_message
        ];
    }
}
