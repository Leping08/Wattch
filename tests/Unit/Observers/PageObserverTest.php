<?php


namespace Tests\Unit\Observers;


use App\Jobs\AnalyzePage;
use App\Jobs\CaptureScreenshot;
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

        $site = factory(\App\Website::class)->create();
    }

    /** @test */
    public function created_it_should_execute_a_capture_a_screen_shot_job()
    {
        $this->fakeHttpResponse();

        $this->expectsJobs(CaptureScreenshot::class);

        $site = factory(\App\Website::class)->create();
    }

    /** @test */
    public function created_it_should_create_a_recurring_task()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $page = $site->pages->first();

        $tasks = \App\Task::where('taskable_type', 'App\Page')->where('taskable_id', $page->id)->get();

        $this->assertEquals(1, $tasks->count());
    }

    /** @test */
    public function updated_it_should_execute_a_analyze_page_job()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $page = $site->pages->first();

        $page->route = '/news';

        $this->expectsJobs(AnalyzePage::class);

        $page->save();
    }

    /** @test */
    public function updated_it_should_execute_a_capture_a_screen_shot_job()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $page = $site->pages->first();

        $page->route = '/news';

        $this->expectsJobs(CaptureScreenshot::class);

        $page->save();
    }

    /** @test */
    public function deleted_it_should_delete_all_http_responses_tasks_and_screenshots()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $page = $site->pages->first();

        $this->assertEquals(1, $page->http_responses->count());
        $this->assertEquals(1, $page->tasks->count());
        $this->assertEquals(1, $page->screenshots->count());

        $this->assertEquals(1, \App\HttpResponse::all()->count());
        $this->assertEquals(1,
            \App\Task::where('taskable_type', 'App\Page')->where('taskable_id', $page->id)->get()->count());
        $this->assertEquals(1, \App\Screenshot::all()->count());

        $page->delete();

        $this->assertEquals(0, \App\HttpResponse::all()->count());
        $this->assertEquals(0,
            \App\Task::where('taskable_type', 'App\Page')->where('taskable_id', $page->id)->get()->count());
        $this->assertEquals(0, \App\Screenshot::all()->count());
    }

    /** @test */
    public function restored_it_should_restore_all_http_responses_tasks_and_screenshots()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $page = $site->pages->first();

        $this->assertEquals(1, $page->http_responses->count());
        $this->assertEquals(1, $page->tasks->count());
        $this->assertEquals(1, $page->screenshots->count());

        $this->assertEquals(1, \App\HttpResponse::all()->count());
        $this->assertEquals(1,
            \App\Task::where('taskable_type', 'App\Page')->where('taskable_id', $page->id)->get()->count());
        $this->assertEquals(1, \App\Screenshot::all()->count());

        $page->delete();

        $this->assertEquals(0, \App\HttpResponse::all()->count());
        $this->assertEquals(0,
            \App\Task::where('taskable_type', 'App\Page')->where('taskable_id', $page->id)->get()->count());
        $this->assertEquals(0, \App\Screenshot::all()->count());

        $this->assertEquals(1, \App\Page::withTrashed()->get()->count());

        $page = \App\Page::withTrashed()->first();
        $page->restore();

        $this->assertEquals(1, \App\Page::all()->count());
        $this->assertEquals(2, \App\HttpResponse::all()->count());
        $this->assertEquals(1, \App\Task::where('taskable_type', 'App\Page')->where('taskable_id', $page->id)->get()->count());
        $this->assertEquals(2, \App\Screenshot::all()->count());
    }
}
