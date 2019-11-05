<?php

namespace App;

use App\Library\Traits\ProductHelpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Billable;

/**
 * A model for a user. This is someone who login's into the application
 *
 * An Eloquent Model: 'User'
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property integer $stripe_id
 * @property string $card_brand
 * @property string $card_last_four
 * @property Carbon $trial_ends_at
 * @property-read Website $websites
 * @property-read Product $product
 * @property-read Subscription $subscription
 * @property-read Feature $features
 *
 */
class User extends Authenticatable
{
    use Notifiable, Billable, SoftDeletes, ProductHelpers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function websites()
    {
        return $this->hasMany(Website::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subscription()
    {
        return $this->hasOne(Subscription::class, 'user_id'); //TODO this could have many
    }
}
