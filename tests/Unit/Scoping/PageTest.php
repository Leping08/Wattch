<?php

namespace Tests\Unit\Scoping;

use App\Models\Page;
use App\Models\User;
use App\Models\Website;
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

        $user_1 = factory(User::class)->create();
        $user_2 = factory(User::class)->create();

        $this->be($user_1);
        $website_1 = factory(Website::class)->create([
            'user_id' => $user_1,
        ]);
        $page_1 = factory(Page::class)->create([
            'website_id' => $website_1->id,
        ]);
        $this->assertCount(1, Page::all());

        $this->be($user_2);
        $website_2 = factory(Website::class)->create([
            'user_id' => $user_2,
        ]);
        $page_2 = factory(Page::class)->create([
            'website_id' => $website_2->id,
        ]);
        $this->assertCount(1, Page::all());

        $this->be($user_1);
        factory(Page::class)->create([
            'website_id' => $website_1->id,
            'route' => '/test',
        ]);
        $this->assertCount(2, Page::all());

        $this->be($user_2);
        $this->assertCount(1, Page::all());

        $this->be($user_2);
        factory(Page::class)->create([
            'website_id' => $website_2->id,
            'route' => '/test',
        ]);
        $this->assertCount(2, Page::all());

        $this->be($user_1);
        $this->assertCount(2, Page::all());
    }
}
