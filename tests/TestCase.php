<?php

namespace Tests;

use App\Website;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->seed();
    }


    /**
     * @return Website
     */
    public function createUserAndWebsite()
    {
        $user = factory(\App\User::class)->create();
        $this->be($user);

        $site = factory(\App\Website::class)->create([
            'user_id' => $user
        ]);

        return $site;
    }
}
