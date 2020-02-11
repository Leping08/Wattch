<?php

namespace App;

use App\Jobs\AnalyzePage;
use App\Jobs\CaptureScreenshot;
use App\Library\Interfaces\Taskable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * A page for a website. This is a route for a website.
 * Ex: '/about-us'.
 *
 * An Eloquent Model: 'Page'
 *
 * @property int $id
 * @property int $website_id
 * @property string $route
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Website $website
 * @property-read HttpResponse $http_responses
 * @property-read HttpResponse $latest_http_response
 * @property-read Screenshot $screenshots
 * @property-read Task $tasks
 * @property-read Assertion $assertions
 * @property-read ScreenshotSchedule $screenshotSchedule
 * @property string $full_route
 * @property bool $passing
 */
class Page extends Model implements Taskable
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'website_id',
        'route',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'passing' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            $builder->whereIn('website_id', Website::pluck('id'));  //All websites is already user scoped
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function website()
    {
        return $this->belongsTo(Website::class, 'website_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function http_responses()
    {
        return $this->hasMany(HttpResponse::class, 'page_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_http_response()
    {
        return $this->hasOne(HttpResponse::class, 'page_id')->latest('id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function screenshots()
    {
        return $this->hasMany(Screenshot::class, 'page_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_screenshot()
    {
        return $this->hasOne(Screenshot::class, 'page_id')->latest('id');
    }

    /**
     * @return string
     */
    public function getFullRouteAttribute()
    {
        return $this->remove_trailing_slashes($this->website->domain).$this->route;
    }

    /**
     * @param $url
     * @return string
     * @see remove_trailing_slashes
     */
    public function remove_trailing_slashes($url)
    {
        return rtrim($url, '/');
    }

    /**
     * @return bool
     */
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

    /**
     * @return void
     */
    public function execute()
    {
        Log::info("Executing Page:$this->id");
        AnalyzePage::dispatchNow($this);
    }

    /**
     * @return void
     */
    public function screenshot()
    {
        CaptureScreenshot::dispatchNow($this);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assertions()
    {
        return $this->hasMany(Assertion::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function screenshotSchedule()
    {
        return $this->hasOne(ScreenshotSchedule::class);
    }
}
