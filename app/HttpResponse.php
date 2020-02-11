<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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
 * @property int $id
 * @property int $page_id
 * @property string $domain
 * @property int $response_code
 * @property string $ip
 * @property float $total_time
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Website $website
 * @property-read HttpResponse $http_responses
 * @property-read HttpResponse $latest_http_response
 * @property-read Screenshot $screenshots
 * @property-read Task $tasks
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
        'request_stats_raw',
    ];

    protected $casts = [
        'headers_raw' => 'array',
        'request_stats_raw' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            $builder->whereIn('page_id', Page::pluck('id'));  //Pages are already user scoped
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return ! Str::startsWith($this->response_code, '4');
    }
}
