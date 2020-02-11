<?php

namespace Tests\Unit\Observers;

use App\HttpResponse;
use App\Jobs\AnalyzePage;
use App\Page;
use App\ScreenshotSchedule;
use App\Task;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class PageObserverTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function created_it_should_execute_a_analyze_page_job()
    {
        $this->fakeHttpResponse();

        $this->expectsJobs(AnalyzePage::class);

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);
    }

    /** @test */
    public function created_it_should_create_a_screenshot_schedule_model_for_the_page()
    {
        $this->fakeHttpResponse();

        $this->assertCount(0, ScreenshotSchedule::all());

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $this->assertCount(1, ScreenshotSchedule::all());
    }

//    /** @test */
//    public function created_it_should_execute_a_capture_a_screen_shot_job()
//    {
//        $this->fakeHttpResponse();
//
//        $this->expectsJobs(CaptureScreenshot::class);
//
//        $site = factory(Website::class)->create();
//    }
//
//    /** @test */
//    public function created_it_should_create_a_screenshot_schedule_recurring_task()
//    {
//        $this->fakeHttpResponse();
//
//        $site = factory(Website::class)->create();
//
//        $page = factory(Page::class)->create([
//            'website_id' => $site->id
//        ]);
//
//        $tasks = Task::where('taskable_type', ScreenshotSchedule::class)->where('taskable_id', $page->id)->get();
//
//        $this->assertEquals(1, $tasks->count());
//    }

    /** @test */
    public function created_it_should_create_a_recurring_task()
    {
        $this->fakeHttpResponse();

        $this->assertCount(0, Task::where('taskable_type', Page::class)->get());

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $this->assertCount(1, Task::where('taskable_type', Page::class)->get());
    }

    /** @test */
    public function updated_it_should_execute_a_analyze_page_job()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $this->expectsJobs(AnalyzePage::class);

        $page->route = '/news';
        $page->save();
    }

    /** @test */
    public function deleted_it_should_delete_all_http_responses()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $this->assertEquals(1, $page->http_responses->count());

        $page->delete();

        $this->assertEquals(0, HttpResponse::all()->count());
    }

    /** @test */
    public function deleted_it_should_delete_all_tasks()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $this->assertEquals(1, $page->tasks->count());

        $page->delete();

        $this->assertEquals(0, Task::where('taskable_type', Page::class)->where('taskable_id', $page->id)->get()->count());
    }

    /** @test */
    public function deleted_it_should_delete_all_screenshot_schedules()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/',
        ]);

        $this->assertCount(1, ScreenshotSchedule::all());

        $page->delete();

        $this->assertCount(0, ScreenshotSchedule::all());
    }

    /** @test */
    public function restored_it_should_restore_all_http_responses_tasks_screenshot_schedules_and_screenshots()
    {
        //TODO figure out how to deal with restoring a page
        $this->assertTrue(true);
    }
}
