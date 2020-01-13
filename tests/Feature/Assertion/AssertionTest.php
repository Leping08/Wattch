<?php


namespace Tests\Feature;


use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AssertionTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test()
    {
        $this->assertTrue(true);
    }
}
