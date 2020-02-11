<?php

namespace App;

use App\Jobs\CaptureScreenshot;
use App\Library\Interfaces\Taskable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * This is a reference to a page and allows for
 * the scheduling of screenshots in the tasks table.
 *
 * An Eloquent Model: 'ScreenshotSchedule'
 *
 * @property int $id
 * @property int $page_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Page $page
 */
class ScreenshotSchedule extends Model implements Taskable
{
    use SoftDeletes;

    protected $fillable = [
        'page_id',
    ];
    //TODO: Add some sort of scope here

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    /**
     * @return void
     */
    public function execute()
    {
        CaptureScreenshot::dispatchNow($this->page);
    }
}
