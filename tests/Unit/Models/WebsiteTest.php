<?php

namespace Tests\Unit\Models;

use App\Jobs\AnalyzeWebsite;
use App\Page;
use App\SslResponse;
use App\Task;
use App\User;
use App\Website;
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

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $this->assertInstanceOf(User::class, $website->user);
    }

    /** @test */
    public function it_has_many_pages()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        foreach ($website->pages as $page) {
            $this->assertInstanceOf(Page::class, $page);
        }
    }

    /** @test */
    public function it_has_many_ssl_certs()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        foreach ($website->ssl_certs as $cert) {
            $this->assertInstanceOf(SslResponse::class, $cert);
        }
    }

    /** @test */
    public function it_has_a_latest_ssl_response()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $this->assertInstanceOf(SslResponse::class, $website->latest_ssl_response);
    }

    /** @test */
    public function it_has_a_home_page()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
            'route' => '/'
        ]);

        $this->assertInstanceOf(Page::class, $website->home_page);
    }

    /** @test */
    public function it_has_a_link_attribute()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $this->assertEquals("/website/1", $website->link);
    }

    /** @test */
    public function it_has_tasks()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $this->assertInstanceOf(Task::class, $website->tasks->first());
    }

    /** @test */
    public function it_has_a_execute_method_that_creates_an_analyze_website_job()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $this->expectsJobs(AnalyzeWebsite::class);

        $website->execute();
    }
}
