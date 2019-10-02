<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class HttpResponse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'page_id',
        'domain',
        'response_code',
        'ip',
        'total_time',
        'headers_raw',
        'request_stats_raw'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function valid()
    {
        // Return true if its not a 400 page
        return !Str::startsWith($this->response_code, '4');
    }
}
