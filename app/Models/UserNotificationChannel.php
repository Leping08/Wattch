<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * This is the pivot model for notification channels and users.
 * It also contains the user speciffic channel settings.
 * Ex Webhook url's, Phone Numbers, Override email addresses.
 *
 * An Eloquent Model: 'UserNotificationChannel'
 *
 * @property int $id
 * @property int $user_id
 * @property int $channel_id
 * @property string $settings
 * @property-read  bool muted
 * @property Carbon $muted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class UserNotificationChannel extends Pivot
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'user_notification_channels';

    /**
     * @var array
     */
    protected $dates = [
        'muted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'channel_id',
        'user_id',
        'settings',
        'muted_at',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'muted',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            if (Auth::check()) {
                return $builder->where('user_id', Auth::id());
            } else {
                return $builder;
            }
        });
    }

    /**
     * @return bool
     */
    public function getMutedAttribute()
    {
        return $this->muted_at ? true : false;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notification_channel()
    {
        return $this->belongsTo(NotificationChannel::class, 'channel_id');
    }

    public function getSettingsAttribute($value)
    {
        return json_decode($value, true);
    }
}
