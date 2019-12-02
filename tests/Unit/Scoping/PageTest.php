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

        $user_1 = factory(\App\User::class)->create(); //This is the system user and does not have scoping
        $user_2 = factory(\App\User::class)->create();
        $user_3 = factory(\App\User::class)->create();

        $this->be($user_2);
        $site_2 = factory(\App\Website::class)->create([
            'user_id' => $user_2
        ]);
        $this->assertCount(1, Page::all());

        $this->be($user_3);
        factory(\App\Website::class)->create([
            'user_id' => $user_3
        ]);
        $this->assertCount(1, Page::all());

        $this->be($user_2);
        factory(\App\Page::class)->create([
            'website_id' => $site_2->id
        ]);
        $this->assertCount(2, Page::all());

        $this->be($user_3);
        $this->assertCount(1, Page::all());

        $this->be($user_2);
        factory(\App\Page::class)->create([
            'website_id' => $site_2->id
        ]);
        $this->assertCount(3, Page::all());

        $this->be($user_3);
        $this->assertCount(1, Page::all());
    }
}
