<?php

namespace App\Observers;

use App\Models\Assertion;
use App\Models\HttpResponse;
use App\Models\Page;
use App\Models\Screenshot;
use App\Models\ScreenshotSchedule;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class PageObserver
{
    /**
     * Handle the page "created" event.
     *
     * @param Page $page
     * @return void
     */
    public function created(Page $page)
    {
        $page->execute();

        Task::create([
            'taskable_type' => Page::class,
            'taskable_id' => $page->id,
            'frequency' => 'hourly',
        ]);

        $schedule = ScreenshotSchedule::create([
            'page_id' => $page->id,
        ]);
    }

    /**
     * Handle the page "updated" event.
     *
     * @param Page $page
     * @return void
     */
    public function updated(Page $page)
    {
        $page->execute();
    }

    /**
     * Handle the page "deleting" event.
     *
     * @param Page $page
     * @return void
     */
    public function deleting(Page $page)
    {
        Log::info('Deleting Page Id: '.$page->id);

        //Delete any http_responses related to the page
        foreach ($page->http_responses as $response) {
            $response->delete();
        }

        //Delete any tasks related to the page
        foreach ($page->tasks as $task) {
            $task->delete();
        }

        //Delete any screenshots related to the page
        foreach ($page->screenshots as $screenshot) {
            $screenshot->delete();
        }

        //Delete any assertions related to the page
        foreach ($page->assertions as $assertion) {
            $assertion->delete();
        }

        //Delete any screenshot schedules related to the page
        if ($page->screenshotSchedule) {
            $page->screenshotSchedule->delete();
        }
    }

    /**
     * Handle the page "restored" event.
     *
     * @param Page $page
     * @return void
     */
    public function restored(Page $page)
    {
        Log::info('Restoring Page Id: '.$page->id);

        //Restore any HttpResponses related to the page
        $https = HttpResponse::withTrashed()
            ->where('page_id', $page->id)
            ->get();

        foreach ($https as $http) {
            $http->restore();
        }

        //Restore any Tasks related to the page
        $tasks = Task::withTrashed()
            ->where('taskable_type', \App\Models\Page::class)
            ->where('taskable_id', $page->id)
            ->get();

        foreach ($tasks as $task) {
            $task->restore();
        }

        //Restore any Screenshots related to the page
        $screenshots = Screenshot::withTrashed()
            ->where('page_id', $page->id)
            ->get();

        foreach ($screenshots as $screenshot) {
            $screenshot->restore();
        }

        //Restore any Assertions related to the page
        $assertions = Assertion::withTrashed()
            ->where('page_id', $page->id)
            ->get();

        foreach ($assertions as $assertion) {
            $assertion->restore();
        }

        //Restore any ScreenshotSchedules related to the page
        $screenshotSchedules = ScreenshotSchedule::withTrashed()
            ->where('page_id', $page->id)
            ->get();

        foreach ($screenshotSchedules as $screenshotSchedule) {
            $screenshotSchedule->restore();
        }
    }

    /**
     * Handle the page "force deleted" event.
     *
     * @param Page $page
     * @return void
     */
    public function forceDeleted(Page $page)
    {
        //
    }
}
