<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * A model for a SslResponse. This is the response related to the
 * ssl certificate for the website.
 *
 * An Eloquent Model: 'SslResponse'
 *
 * @property integer $id
 * @property integer $website_id
 * @property boolean $ssl_valid
 * @property integer $ssl_expires_in
 * @property string $ssl_raw
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Website $website
 *
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

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
}
