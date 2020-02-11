<?php

namespace Tests\Feature\Settings;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class AccountTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test()
    {
        $this->assertTrue(true);
    }
}
