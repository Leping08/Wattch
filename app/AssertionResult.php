<?php

namespace App;

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
 * @property integer $id
 * @property integer $assertion_id
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
        'error_message'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assertion()
    {
        return $this->belongsTo(Assertion::class);
    }
}
