<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * A model for a feature. This is where the
 * rules for a feature are stored.
 *
 * An Eloquent Model: 'Feature'
 *
 * @property integer $id
 * @property integer $product_id
 * @property string $name
 * @property string $description
 * @property string $rules
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Product $product
 *
 */
class Feature extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'rules'
    ];

    protected $casts = [
        'rules' => 'array'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
