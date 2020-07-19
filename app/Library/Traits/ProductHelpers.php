<?php

namespace App\Library\Traits;

use App\Models\Plan;
use App\Models\Product;

trait ProductHelpers
{
    /**
     * @return Product|null
     */
    public function product()
    {
        return $this->subscriptions->active() ?? null;
    }

    /**
     * @return Plan|null
     */
    public function plan()
    {
        return $this->product()->plan ?? null;
    }

    /**
     * @return Plan|null
     */
    public function active_plan()
    {
        return $this->with(['subscription' => function ($query) {
                $query->where('stripe_status', '=', 'active')->with('plan');
            }])->get()->first()->subscription[0]->plan ?? null;
    }

    /**
     * @param  string  $product
     * @return bool
     */
    public function has(string $product) : bool
    {
        $product_id = $this->product()->id ?? null;

        if (! $product_id) {
            return false;
        }

        if ($product === 'baby') {
            return $product_id === 1;
        } elseif ($product === 'security') {
            return $product_id === 2;
        } elseif ($product === 'pi') {
            return $product_id === 3;
        } else {
            return false;
        }
    }
}
