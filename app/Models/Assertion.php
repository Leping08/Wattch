<?php

namespace App\Models;

use App\Jobs\AnalyzeAssertion;
use App\Library\Interfaces\Taskable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * A model for an Assertion.
 * This is a method that can be called on a page.
 * It is used to assert the results of a request to a page.
 *
 * An Eloquent Model: 'Assertion'
 *
 * @property int $id
 * @property int $page_id
 * @property string $assertion_type_id
 * @property array $parameters
 * @property Carbon $muted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Page $page
 * @property-read AssertionType $type
 * @property-read AssertionResult $results
 * @property-read Task $tasks
 */
class Assertion extends Model implements Taskable
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'page_id',
        'assertion_type_id',
        'parameters',
        'muted_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'parameters' => 'json',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'muted_at',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'muted',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AssertionType::class, 'assertion_type_id');
    }

    /**
     * @return void
     */
    public function execute()
    {
        Log::info("Executing Assertion:$this->id");
        AnalyzeAssertion::dispatchNow($this);
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
    public function results()
    {
        return $this->hasMany(AssertionResult::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latest_result()
    {
        return $this->hasOne(AssertionResult::class)->latest('id');
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->page->website->user;
    }

    /**
     * @return bool
     */
    public function getMutedAttribute()
    {
        return $this->muted_at ? true : false;
    }
}
