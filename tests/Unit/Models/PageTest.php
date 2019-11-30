<?php

namespace Tests\Unit\Models;

use App\Jobs\AnalyzePage;
use App\Jobs\CaptureScreenshot;
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

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

        $this->assertInstanceOf(\App\Website::class, $page->website);
    }

    /** @test */
    public function it_has_http_responses()
    {
        $this->fakeHttpResponse();

        $site = $this->createUserAndWebsite();

        foreach ($site->ssl_certs as $cert) {
            $this->assertInstanceOf(\App\SslResponse::class, $cert);
        }

        $this->assertInstanceOf(\App\SslResponse::class, $site->latest_ssl_response);

        $this->assertEquals(1, $site->ssl_certs->count());
    }

    /** @test */
    public function it_has_tasks()
    {
        $this->fakeHttpResponse();

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

        $task = $page->tasks->first();

        $this->assertInstanceOf(\App\Task::class, $task);
    }

    /** @test */
    public function it_has_screenshots()
    {
        $this->fakeHttpResponse();

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

        $screenshots = $page->screenshots->first();

        $this->assertInstanceOf(\App\Screenshot::class, $screenshots);
    }

    /** @test */
    public function it_has_a_full_route_attribute()
    {
        $this->fakeHttpResponse();

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

        $this->assertEquals($page->fullRoute, "https://www.google.com/");
    }

    /** @test */
    public function it_has_a_strip_trailing_slashes_method()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $page = \App\Page::create([
            'website_id' => $site->id,
            'route' => '/news/'
        ]);

        $this->assertEquals("/news", $page->remove_trailing_slashes($page->route));
    }

    /** @test */
    public function it_has_a_passing_attribute()
    {
        $this->fakeHttpResponse();

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

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

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

        $this->expectsJobs(AnalyzePage::class);

        $page->execute();
    }

    /** @test */
    public function it_has_a_screenshot_method_that_creates_an_capture_screenshot_job()
    {
        $this->fakeHttpResponse();

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

        $this->expectsJobs(CaptureScreenshot::class);

        $page->screenshot();
    }
}
