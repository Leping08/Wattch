<?php

namespace App\Observers;

use App\ScreenshotSchedule;
use App\Task;
use Illuminate\Support\Facades\Log;

class ScreenshotScheduleObserver
{
    /**
     * Handle the screenshot schedule "created" event.
     *
     * @param  \App\ScreenshotSchedule  $screenshotSchedule
     * @return void
     */
    public function created(ScreenshotSchedule $screenshotSchedule)
    {
        $screenshotSchedule->execute();

        Task::create([
            'taskable_type' => ScreenshotSchedule::class,
            'taskable_id' => $screenshotSchedule->id,
            'frequency' => 'daily'
        ]);
    }

    /**
     * Handle the screenshot schedule "updated" event.
     *
     * @param  \App\ScreenshotSchedule  $screenshotSchedule
     * @return void
     */
    public function updated(ScreenshotSchedule $screenshotSchedule)
    {
        $screenshotSchedule->execute();
    }

    /**
     * Handle the screenshot schedule "deleting" event.
     *
     * @param  \App\ScreenshotSchedule  $screenshotSchedule
     * @return void
     */
    public function deleting(ScreenshotSchedule $screenshotSchedule)
    {
        Log::info('Deleting ScreenshotSchedule ID: ' . $screenshotSchedule->id);
    }

    /**
     * Handle the screenshot schedule "restored" event.
     *
     * @param  \App\ScreenshotSchedule  $screenshotSchedule
     * @return void
     */
    public function restored(ScreenshotSchedule $screenshotSchedule)
    {
        //
    }

    /**
     * Handle the screenshot schedule "force deleted" event.
     *
     * @param  \App\ScreenshotSchedule  $screenshotSchedule
     * @return void
     */
    public function forceDeleted(ScreenshotSchedule $screenshotSchedule)
    {
        //
    }
}
