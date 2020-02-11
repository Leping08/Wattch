<?php

namespace Tests\Unit\Models;

use App\Jobs\CaptureScreenshot;
use App\Page;
use App\Screenshot;
use App\Website;
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

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $screenshot = factory(Screenshot::class)->create([
            'page_id' => $page->id,
        ]);

        $this->assertInstanceOf(Page::class, $screenshot->page);
    }
}
