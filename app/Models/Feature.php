<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * A model for a feature. This is where the
 * rules for a feature are stored.
 *
 * An Eloquent Model: 'Feature'
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $description
 * @property string $rules
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Product $product
 */
class Feature extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'description',
        'rules',
    ];

    protected $casts = [
        'rules' => 'array',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
