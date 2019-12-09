<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * A model for a task. This is where all the scheduling happens.
 * It uses the laravel scheduler https://laravel.com/docs/scheduling
 *
 * An Eloquent Model: 'Task'
 *
 * @property integer $id
 * @property string $taskable_type
 * @property string $taskable_id
 * @property string $frequency
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Task $taskable
 *
 */
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'taskable_type',
        'taskable_id',
        'frequency'
    ];

//    protected static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope('user', function (Builder $builder) {
//            $builder->whereIn('page_id', Page::all());  //TODO Make this model user scoped
//        });
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function taskable()
    {
        return $this->morphTo();
    }
}
