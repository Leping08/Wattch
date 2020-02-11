<?php

namespace Tests\Unit\Observers;

use App\Jobs\CaptureScreenshot;
use App\Models\Page;
use App\Models\Screenshot;
use App\Models\ScreenshotSchedule;
use App\Models\Task;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class ScreenshotScheduleObserverTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function created_it_should_execute_a_capture_screenshot_job()
    {
        $this->fakeHttpResponse();

        $this->expectsJobs(CaptureScreenshot::class);

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([ //This creates a screenshot schedule
            'website_id' => $website->id,
            'route' => '/',
        ]);

        factory(ScreenshotSchedule::class)->create();
    }

    /** @test */
    public function created_it_should_create_a_screenshot_schedule_job()
    {
        $this->fakeHttpResponse();

        $this->assertCount(0, Task::where('taskable_type', \App\Models\ScreenshotSchedule::class)->get());

        $schedule = factory(ScreenshotSchedule::class)->create();

        $this->assertCount(1, Task::where('taskable_type', \App\Models\ScreenshotSchedule::class)->where('taskable_id', $schedule->id)->get());
    }

    /** @test */
    public function updated_it_should_execute_a_capture_screenshot_job()
    {
        $this->fakeHttpResponse();

        $schedule = factory(ScreenshotSchedule::class)->create();

        $this->expectsJobs(CaptureScreenshot::class);

        $schedule->page_id = 3;
        $schedule->save();
    }
}
