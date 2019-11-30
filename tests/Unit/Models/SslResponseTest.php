<?php

namespace Tests\Unit\Models;

use App\SslResponse;
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

        $site = $this->createUserAndWebsite();

        $ssl = SslResponse::first();

        $this->assertInstanceOf(\App\Website::class, $ssl->website);
    }
}
