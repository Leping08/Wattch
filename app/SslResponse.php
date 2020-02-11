<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * A model for a SslResponse. This is the response related to the
 * ssl certificate for the website.
 *
 * An Eloquent Model: 'SslResponse'
 *
 * @property int $id
 * @property int $website_id
 * @property bool $ssl_valid
 * @property int $ssl_expires_in
 * @property string $ssl_raw
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Website $website
 */
class SslResponse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'website_id',
        'ssl_valid',
        'ssl_expires_in',
        'ssl_raw',
    ];

    protected $casts = [
        'ssl_raw' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            $builder->whereIn('website_id', Website::pluck('id'));  //Pages are already user scoped
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
}
