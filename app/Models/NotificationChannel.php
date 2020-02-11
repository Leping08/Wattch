<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * These are all the different ways a user can be
 * notified about an assertion failing
 *
 * An Eloquent Model: 'NotificationChannel'
 *
 * @property int $id
 * @property string $name
 * @property string $config
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read User $users
 */
class NotificationChannel extends Model
{
    use SoftDeletes;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_notification_channels', 'channel_id', 'user_id')->withTimestamps();
    }
}
