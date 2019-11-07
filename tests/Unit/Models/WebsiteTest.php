<?php

namespace Tests\Unit\Models;

use App\Jobs\AnalyzeWebsite;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class WebsiteTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $this->assertInstanceOf(\App\User::class, $site->user);
    }

    /** @test */
    public function it_has_many_pages()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        foreach ($site->pages as $page) {
            $this->assertInstanceOf(\App\Page::class, $page);
        }
    }

    /** @test */
    public function it_has_many_ssl_certs()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        foreach ($site->ssl_certs as $cert) {
            $this->assertInstanceOf(\App\SslResponse::class, $cert);
        }
    }

    /** @test */
    public function it_has_a_latest_ssl_response()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $this->assertInstanceOf(\App\SslResponse::class, $site->latest_ssl_response);
    }

    /** @test */
    public function it_has_a_home_page()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $this->assertInstanceOf(\App\Page::class, $site->home_page);
    }

    /** @test */
    public function it_has_a_link_attribute()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $this->assertEquals("/website/1", $site->link);
    }

    /** @test */
    public function it_has_tasks()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $this->assertInstanceOf(\App\Task::class, $site->tasks->first());
    }

    /** @test */
    public function it_has_a_execute_method_that_creates_an_analyze_website_job()
    {
        $this->fakeHttpResponse();

        $site = factory(\App\Website::class)->create();

        $this->expectsJobs(AnalyzeWebsite::class);

        $site->execute();
    }
}
