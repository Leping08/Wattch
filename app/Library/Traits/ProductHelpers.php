<?php

namespace App\Library\Traits;

trait ProductHelpers
{
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
