<?php

namespace Tests\Unit\Scoping;

use App\User;
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

        $user_1 = factory(User::class)->create(); //This is the system user and does not have scoping
        $user_2 = factory(User::class)->create();
        $user_3 = factory(User::class)->create();

        $this->be($user_3);
        $site_1 = factory(Website::class)->create([
            'user_id' => $user_3,
        ]);

        $this->be($user_2);
        $site_2 = factory(Website::class)->create([
            'user_id' => $user_2,
        ]);

        $this->be($user_3);
        $this->assertCount(1, Website::all());

        $site_3 = factory(Website::class)->create([
            'user_id' => $user_3,
        ]);

        $this->assertCount(2, Website::all());

        $this->be($user_2);
        $site_4 = factory(Website::class)->create([
            'user_id' => $user_2,
        ]);
        $site_5 = factory(Website::class)->create([
            'user_id' => $user_2,
        ]);
        $site_6 = factory(Website::class)->create([
            'user_id' => $user_2,
        ]);
        $this->assertCount(4, Website::all());

        $this->be($user_3);
        $this->assertCount(2, Website::all());
    }
}
