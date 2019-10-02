<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_website()
    {
        factory(\App\Website::class)->create();

        $page = \App\Page::first();

        $this->assertInstanceOf(\App\Website::class, $page->website);
    }

    /** @test */
    public function it_has_http_responses()
    {
        factory(\App\Website::class)->create();

        $page = \App\Page::first();

        $page->execute();

        $this->assertEquals(2, $page->http_responses->count());

        Storage::disk('public')->assertExists('screenshots/page_1/' . $page->screenshots->first()->uuid . '.png');
    }
}
