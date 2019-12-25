<?php


namespace App\Library\Traits;


use App\NotificationChannel;
use Illuminate\Support\Collection;

trait NotificationChannels
{
    /**
     * @return Collection
     */
    public function via_notification_channels()
    {
        return $this->notification_channels->pluck('name');
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return NotificationChannel
     */
    public function slackNotificationChannel()
    {
        return $this->notification_channels->where('name', 'slack')->first() ?? null;
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function slackWebhookUrl()
    {
        return $this->slackNotificationChannel()->pivot->settings['webhook_url'] ?? null;
    }
}
