<?php

namespace App;

use App\Jobs\AnalyzeWebsite;
use App\Library\Interfaces\Taskable;
use App\Scopes\UserScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

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
        return $this->belongsTo(User::class,'user_id');
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

    public function getLinkAttribute() : string
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

    public function createHomePage()
    {
        Page::create([
            'website_id' => $this->id,
            'route' => '/'
        ]);
    }
}
