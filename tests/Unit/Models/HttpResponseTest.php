<?php

namespace Tests\Unit\Models;

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

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

        $response = factory(\App\HttpResponse::class)->create([
            'page_id' => $page->id
        ]);

        $this->assertInstanceOf(\App\Page::class, $response->page);
    }

    /** @test */
    public function it_can_be_valid_or_not_valid()
    {
        $this->fakeHttpResponse();

        $site = $this->createUserAndWebsite();

        $page = $site->pages->first();

        $response = factory(\App\HttpResponse::class)->create([
            'page_id' => $page->id
        ]);

        $this->assertTrue($response->valid());

        $response->response_code = 404;
        $response->save();

        $this->assertFalse($response->valid());
    }
}
