<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * A model for a website response. This is the
 * result of a guzzle call.
 *
 * An Eloquent Model: 'HttpResponse'
 *
 * @property integer $id
 * @property integer $page_id
 * @property string $domain
 * @property integer $response_code
 * @property string $ip
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Website $website
 * @property-read HttpResponse $http_responses
 * @property-read HttpResponse $latest_http_response
 * @property-read Screenshot $screenshots
 * @property-read Task $tasks
 *
 */
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
