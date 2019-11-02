<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;


/**
 * A model for a product. This groups features
 * and unlocks sections in the UI.
 *
 * An Eloquent Model: 'Product'
 *
 * @property integer $id
 * @property string $name
 * @property string $stripe_plan
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read User $users
 * @property-read Feature $features
 *
 */
class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'stripe_plan'
    ];

    public function users()
    {
        //TODO Make sure this works
        return $this->hasManyThrough(User::class, Subscription::class, 'user_id', 'id');
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'stripe_plan', 'stripe_plan');
    }
}
