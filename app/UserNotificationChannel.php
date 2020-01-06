<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * This is the pivot model for notification channels and users.
 * It also contains the user speciffic channel settings.
 * Ex Webhook url's, Phone Numbers, Override email addresses
 *
 * An Eloquent Model: 'UserNotificationChannel'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $channel_id
 * @property string $settings
 * @property-read  boolean muted
 * @property Carbon $muted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
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
        'muted_at'
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'channel_id',
        'user_id',
        'settings',
        'muted_at'
    ];

    /**
     * @var array
     */
    protected $appends = [
        'muted'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            if (!(Auth::id() == config('auth.system_user_id'))) { //If not the system user apply user scoping
                return $builder->where('user_id', Auth::id());
            } else {
                return $builder;
            }
        });
    }

    /**
     * @return Boolean
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
