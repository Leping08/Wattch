<?php

namespace App\Library\Traits;

use App\Models\NotificationChannel;
use App\Models\UserNotificationChannel;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait NotificationChannels
{
    /**
     * All of the notification channels for the user.
     * @return Collection
     */
    public function viaNotificationChannels()
    {
        return UserNotificationChannel::with('notification_channel')->get()->filter(function ($item) {
            return $item->muted_at == null;
        })->pluck('notification_channel.name');
    }

    /**
     * Route notifications for the Slack channel.
     * @return string
     */
    public function slackWebhookUrl()
    {
        return $this->getNotificationChannel('slack')['settings']['webhook_url'] ?? null;
    }

    /**
     * The email for the users notifications.
     * @return string
     */
    public function notificationEmailAddress()
    {
        $notification_email = $this->getNotificationChannel('mail')['settings']['email'] ?? null;

        return $notification_email ?? $this->email;
    }

    /**
     * Check if the chanel is muted or not.
     * @param  string  $channel
     * @return bool
     */
    public function notificationChannelMuted($channel) //TODO I dont think this works like this
    {
        return $this->getNotificationChannel($channel)->muted;
    }

    /**
     * Get the correct UserNotificationChannel.
     * @param  string  $channel
     * @return UserNotificationChannel
     */
    public function getNotificationChannel($channel)
    {
        $channel_id = NotificationChannel::where('name', $channel)->first()->id;

        return UserNotificationChannel::where('user_id', Auth::id())->where('channel_id', $channel_id)->first();
    }

    /**
     * Get the correct UserNotificationChannel.
     * @param  string  $channel
     * @param  bool  $state
     */
    public function toggleSetting($channel, $state)
    {
        $user_notification_channel = $this->getNotificationChannel($channel);

        if ($state) { //Toggle is on so the user wants the notifications active
            if ($user_notification_channel->muted) { //If the channel is muted
                Log::info("Updating the $channel notification toggle for User Id $this->id to be muted");
                $user_notification_channel->muted_at = null;
                $user_notification_channel->save();
            }
        } else { //Stats is off so the user wants the notifications muted
            if (! $user_notification_channel->muted) { //If the channel is muted
                Log::info("Updating the $channel notification toggle for User Id $this->id to be active");
                $user_notification_channel->muted_at = Carbon::now();
                $user_notification_channel->save();
            }
        }
    }
}
