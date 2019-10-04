<?php

namespace App;

use App\Jobs\CaptureScreenshot;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * A screenshot for a page
 *
 * An Eloquent Model: 'Screenshot'
 *
 * @property integer $id
 * @property string $uuid
 * @property integer $page_id
 * @property string $src
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Page $page
 *
 */
class Screenshot extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'uuid',
        'page_id',
        'src'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function execute()
    {
        Log::info("Executing Screenshot:$this->id");
        CaptureScreenshot::dispatchNow($this);
    }
}
