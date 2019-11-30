<?php


namespace Tests\Unit\Scoping;

use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;


class WebsiteTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_is_scoped_by_user()
    {
        $this->fakeHttpResponse();

        $this->assertCount(0, Website::all());

        $user_1 = factory(\App\User::class)->create();
        $user_2 = factory(\App\User::class)->create();

        $this->be($user_1);
        $site_1 = factory(\App\Website::class)->create([
            'user_id' => $user_1
        ]);

        $this->be($user_2);
        $site_2 = factory(\App\Website::class)->create([
            'user_id' => $user_2
        ]);

        $this->be($user_1);
        $this->assertCount(1, Website::all());

        $site_3 = factory(\App\Website::class)->create([
            'user_id' => $user_1
        ]);

        $this->assertCount(2, Website::all());

        $this->be($user_2);
        $site_4 = factory(\App\Website::class)->create([
            'user_id' => $user_2
        ]);

        $this->be($user_1);
        $this->assertCount(2, Website::all());
    }
}
