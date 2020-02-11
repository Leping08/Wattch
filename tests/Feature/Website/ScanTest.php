<?php


namespace Tests\Feature\Website;


use App\Jobs\AnalyzeWebsite;
use App\User;
use App\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ScanTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_only_scan_a_website_if_they_own_it()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->be($user1);
        $website1 = factory(Website::class)->create([
            'user_id' => $user1->id
        ]);

        $this->be($user2);
        $website2 = factory(Website::class)->create([
            'user_id' => $user2->id
        ]);

        $this->be($user1);
        $this->post(route('scan.websites', ['website' => $website1->id]))
            ->assertStatus(302);

        $this->post(route('scan.websites', ['website' => $website2->id]))
            ->assertStatus(404);

        $this->be($user2);
        $this->post(route('scan.websites', ['website' => $website2->id]))
            ->assertStatus(302);

        $this->post(route('scan.websites', ['website' => $website1->id]))
            ->assertStatus(404);
    }


    /** @test */
    public function a_analyze_website_job_is_dispatched_when_the_user_hits_the_scan_website_route()
    {
        $user = factory(User::class)->create();

        $this->be($user);
        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $this->expectsJobs(AnalyzeWebsite::class);

        $this->post(route('scan.websites', ['website' => $website->id]))
            ->assertStatus(302);
    }
}