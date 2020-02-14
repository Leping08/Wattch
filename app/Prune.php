<?php


namespace App;


use App\Models\Assertion;
use App\Models\HttpResponse;
use App\Models\Page;
use App\Models\Screenshot;
use App\Models\ScreenshotSchedule;
use App\Models\SslResponse;
use App\Models\Task;
use App\Models\Website;
use Illuminate\Support\Facades\Log;

class Prune
{
    public function run()
    {
        Log::info('Starting clean up');
        $modelsAndRelationships = [
            Website::class => 'user',
            Page::class => 'website',
            SslResponse::class => 'website',
            HttpResponse::class => 'page',
            Assertion::class => 'page',
            Screenshot::class => 'page',
            ScreenshotSchedule::class => 'page',
            Task::class => 'taskable',
        ];

        foreach ($modelsAndRelationships as $model => $relationship) {
            $this->cleanUp($model, $relationship);
        }
    }

    public function cleanUp($model, $relationship)
    {
        foreach ($model::all() as $model) {
            if(! $model->$relationship) {
                Log::info("Could not find $relationship for " . get_class($model) . " ID: $model->id, its being deleted");
                $model->delete();
            }
        }
    }
}