<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * An Eloquent Model: 'AssertionType'.
 *
 * This represents what the assertion is. Ex:
 * assertSee()
 * assertNotFound()
 * assertStatus(int $code)
 *
 * These are documented here:
 * https://laravel.com/docs/master/http-tests
 *
 * @property int $id
 * @property string $name
 * @property string $method
 * @property string $icon
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Assertion $assertion
 * @property string $icon_path
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
        'icon',
        'example',
        'description',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'icon_path',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assertion()
    {
        return $this->belongsTo(Assertion::class);
    }

    /**
     * Get the user's first name.
     *
     * @return string
     */
    public function getIconPathAttribute()
    {
        return asset('img/assertion_types/'.$this->icon);
    }
}
