<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * A model for an AssertionResult.
 * This is the result of an assertion.
 * It can be a success or not and is
 * related back to an assertion.
 *
 * An Eloquent Model: 'AssertionResult'
 *
 * @property int $id
 * @property int $assertion_id
 * @property bool $success
 * @property string $error_message
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Assertion $assertion
 */
class AssertionResult extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'assertion_id',
        'success',
        'error_message',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function (Builder $builder) {
            $builder->whereIn('assertion_id', Assertion::pluck('id'));  //Assertions are already user scoped
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assertion()
    {
        return $this->belongsTo(Assertion::class);
    }
}
