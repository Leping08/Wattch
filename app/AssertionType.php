<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * An Eloquent Model: 'AssertionType'
 *
 * This represents what the assertion is. Ex:
 * assertSee()
 * assertNotFound()
 * assertStatus(int $code)
 *
 * These are documented here:
 * https://laravel.com/docs/master/http-tests
 *
 * @property integer $id
 * @property string $name
 * @property string $method
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Assertion $assertion
 */
class AssertionType extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'method',
        'description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assertion()
    {
        return $this->belongsTo(Assertion::class);
    }
}
