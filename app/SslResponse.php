<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SslResponse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'website_id',
        'ssl_raw',
        'ssl_valid',
        'ssl_expires_in',
    ];

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }
}
