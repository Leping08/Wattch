<?php

namespace Tests\Unit\Models;

use App\Jobs\AnalyzePage;
use App\Jobs\CaptureScreenshot;
use App\Page;
use App\Screenshot;
use App\SslResponse;
use App\Task;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class PageTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_belongs_to_a_website()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $this->assertInstanceOf(Website::class, $page->website);
    }

    /** @test */
    public function it_has_http_responses()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        foreach ($website->ssl_certs as $cert) {
            $this->assertInstanceOf(SslResponse::class, $cert);
        }

        $this->assertInstanceOf(SslResponse::class, $website->latest_ssl_response);

        $this->assertEquals(1, $website->ssl_certs->count());
    }

    /** @test */
    public function it_has_tasks()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $task = $page->tasks->first();

        $this->assertInstanceOf(Task::class, $task);
    }

    /** @test */
    public function it_has_screenshots()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $screenshot = factory(Screenshot::class)->create([
            'page_id' => $page->id,
        ]);

        $screenshots = $page->screenshots->first();

        $this->assertInstanceOf(Screenshot::class, $screenshots);
    }

    /** @test */
    public function it_has_a_full_route_attribute()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/test',
        ]);

        $this->assertEquals($page->fullRoute, 'https://www.google.com/test');
    }

    /** @test */
    public function it_has_a_strip_trailing_slashes_method()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = Page::create([
            'website_id' => $website->id,
            'route' => '/news/',
        ]);

        $this->assertEquals('/news', $page->remove_trailing_slashes($page->route));
    }

    /** @test */
    public function it_has_a_passing_attribute()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $page->execute();

        $response = $page->latest_http_response;
        $response->response_code = 200;

        $response->save();

        $this->assertTrue($page->passing);
    }

    /** @test */
    public function it_has_a_execute_method_that_creates_an_analyze_page_job()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $this->expectsJobs(AnalyzePage::class);

        $page->execute();
    }

    /** @test */
    public function it_has_a_screenshot_method_that_creates_an_capture_screenshot_job()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $this->expectsJobs(CaptureScreenshot::class);

        $page->screenshot();
    }
}
