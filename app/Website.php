<?php

namespace App;

use App\Jobs\AnalyzeWebsite;
use App\Library\Interfaces\Taskable;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * A model for a website. This is the model that most of the rest of
 * the application revolves around.
 *
 * An Eloquent Model: 'Website'
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $domain
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Page $pages
 * @property-read User $user
 * @property-read SslResponse $ssl_certs
 * @property-read SslResponse $latest_ssl_response
 * @property-read string $home_page
 * @property-read string $link
 * @property-read Task $tasks
 *
 */
class Website extends Model implements Taskable
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'domain'
    ];

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope(new UserScope());
//    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pages()
    {
        return $this->hasMany(Page::class, 'website_id');
    }

    public function ssl_certs()
    {
        return $this->hasMany(SslResponse::class, 'website_id');
    }

    public function latest_ssl_response()
    {
        return $this->hasOne(SslResponse::class, 'website_id')->latest();
    }

    public function home_page()
    {
        return $this->hasOne(Page::class, 'website_id')->where('route', '/');
    }

    public function getLinkAttribute(): string
    {
        return '/website/' . $this->id;
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    public function execute()
    {
        Log::info("Executing Website:$this->id");
        AnalyzeWebsite::dispatchNow($this);
    }
}
