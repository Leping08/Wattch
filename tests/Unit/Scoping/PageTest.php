<?php


namespace Tests\Unit\Scoping;

use App\Page;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;


class PageTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_is_scoped_by_user()
    {
        $this->fakeHttpResponse();

        $this->assertCount(0, Page::all());

        $user_1 = factory(\App\User::class)->create();
        $user_2 = factory(\App\User::class)->create();

        $this->be($user_1);
        $site_1 = factory(\App\Website::class)->create([
            'user_id' => $user_1
        ]);

        $this->assertCount(1, Page::all());

        $page = factory(\App\Page::class)->create([
            'website_id' => $site_1->id
        ]);

        $this->assertCount(2, Page::all());
    }
}
