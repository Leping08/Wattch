<?php

namespace App;

use App\Jobs\AnalyzeAssertion;
use App\Library\Interfaces\Taskable;
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
 * @property integer $id
 * @property integer $page_id
 * @property string $assertion_type_id
 * @property array $parameters
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Page $page
 * @property-read AssertionType $type
 * @property-read AssertionResult $results
 *
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
        'name',
        'parameters'
    ];

    /**
     * @var array
     */
    protected $casts = [
        'parameters' => 'json'  //TODO: MAKE SURE SOMEONE CAN NOT RUN CODE FROM THIS
    ];

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
}
