<?php


namespace App\Library\Traits;


trait ProductHelpers
{
    public function product()
    {
        return $this->subscription->product;
    }

    public function features()
    {
        return $this->subscription->product->features;
    }

    public function rules()
    {
        //TODO: Find a good way to do this
        //return $this->subscription->product->features;
    }
}
