<?php


namespace Tests\Unit\Models;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class UserTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function it_has_many_websites()
    {
        $this->fakeHttpResponse();

        $user = factory(\App\User::class)->create();

        $site = factory(\App\Website::class)->create([
            'user_id' => $user->id
        ]);

        $site2 = factory(\App\Website::class)->create([
            'user_id' => $user->id
        ]);

        foreach ($user->websites as $site) {
            $this->assertInstanceOf(\App\Website::class, $site);
        }
    }
}
