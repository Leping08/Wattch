<?php

namespace Tests\Unit\Models;

use App\Page;
use App\SslResponse;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class SslResponseTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_has_belongs_to_a_website()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $ssl = SslResponse::first();

        $this->assertInstanceOf(Website::class, $ssl->website);
    }
}
