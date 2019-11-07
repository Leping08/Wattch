<?php

namespace Tests\Unit\Models;

use App\Jobs\CaptureScreenshot;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class ScreenshotTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_has_belongs_to_a_page()
    {
        $this->fakeHttpResponse();

        factory(\App\Website::class)->create();

        $screenshot = \App\Screenshot::first();

        $this->assertInstanceOf(\App\Page::class, $screenshot->page);
    }
}