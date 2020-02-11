<?php

namespace App\Observers;

use App\User;
use App\UserNotificationChannel;
use App\Website;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function created(User $user)
    {
        //Generate user settings

        //Email
        UserNotificationChannel::create([
            'user_id' => $user->id,
            'channel_id' => 1,
            'settings' => json_encode(['email' => $user->email], JSON_PRETTY_PRINT),
            'muted_at' => Carbon::now(),
        ]);

        //Slack
        UserNotificationChannel::create([
            'user_id' => $user->id,
            'channel_id' => 2,
            'settings' => json_encode(['webhook_url' => null], JSON_PRETTY_PRINT),
            'muted_at' => Carbon::now(),
        ]);
    }

    /**
     * Handle the user "updated" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleting" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function deleting(User $user)
    {
        Log::info('Deleting User Id: '.$user->id);

        //Restore any Website related to the user
        foreach ($user->websites as $website) {
            $website->delete();
        }

        //Restore any Website related to the notification channel
        foreach (UserNotificationChannel::all() as $channel) {
            $channel->delete();
        }

        //TODO Remove from stripe
    }

    /**
     * Handle the user "restored" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function restored(User $user)
    {
        //Restore any Websites related to the user
        $websites = Website::withTrashed()
            ->where('user_id', $user->id)
            ->get();

        foreach ($websites as $website) {
            $website->restore();
        }

        //Restore any UserNotificationChannels related to the user
        $channels = UserNotificationChannel::withTrashed()
            ->where('user_id', $user->id)
            ->get();

        foreach ($channels as $channel) {
            $channel->restore();
        }
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param \App\User $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
