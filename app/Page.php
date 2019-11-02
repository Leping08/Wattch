<?php

namespace App;

use App\Jobs\AnalyzePage;
use App\Jobs\CaptureScreenshot;
use App\Library\Interfaces\Taskable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * A page for a website. This is a route for a website.
 * Ex: '/about-us'
 *
 * An Eloquent Model: 'Page'
 *
 * @property integer $id
 * @property integer $website_id
 * @property string $route
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
class Page extends Model implements Taskable
{
    use SoftDeletes;

    protected $fillable = [
        'website_id',
        'route'
    ];

    protected $casts = [
        'passing' => 'boolean'
    ];

    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

    public function http_responses()
    {
        return $this->hasMany(HttpResponse::class, 'page_id');
    }

    public function latest_http_response()
    {
        return $this->hasOne(HttpResponse::class, 'page_id')->latest();
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    public function screenshots()
    {
        return $this->hasMany(Screenshot::class, 'page_id');
    }

    public function getFullRouteAttribute()
    {
        return $this->remove_trailing_slashes($this->website->domain) . $this->route;
    }

    public function remove_trailing_slashes($url)
    {
        return rtrim($url, '/');
    }

    public function getPassingAttribute(): bool
    {
        if ($this->latest_http_response) {
            if ($this->latest_http_response->response_code == 200) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function execute()
    {
        Log::info("Executing Page:$this->id");
        AnalyzePage::dispatchNow($this);
    }

    public function screenshot()
    {
        CaptureScreenshot::dispatchNow($this);
    }
}
