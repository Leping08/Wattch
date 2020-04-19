<?php

namespace App;

use App\Models\Plan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * A model for a subscription. This is the payment/subscription
 * It uses the laravel cashier and stripe https://laravel.com/docs/master/billing.
 *
 * An Eloquent Model: 'Subscription'
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $stripe_id
 * @property string $stripe_status
 * @property string $stripe_plan
 * @property int $quantity
 * @property Carbon $trial_ends_at
 * @property Carbon $ends_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Product $product
 * @property-read User $user
 */
class Subscription extends \Laravel\Cashier\Subscription
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'stripe_plan', 'stripe_plan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function plan()
    {
        return $this->hasOne(Plan::class, 'stripe_plan', 'stripe_plan');
    }
}
