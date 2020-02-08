<?php

namespace Tests\Unit\Models;

use App\HttpResponse;
use App\Page;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class HttpResponseTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_belongs_to_a_page()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $response = factory(HttpResponse::class)->create([
            'page_id' => $page->id
        ]);

        $this->assertInstanceOf(Page::class, $response->page);
    }

    /** @test */
    public function it_can_be_valid_or_not_valid()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $response = factory(HttpResponse::class)->create([
            'page_id' => $page->id
        ]);

        $this->assertTrue($response->valid());

        $response->response_code = 404;
        $response->save();

        $this->assertFalse($response->valid());
    }
}
