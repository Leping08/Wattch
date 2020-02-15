<?php

namespace Tests\Feature\Page;

use App\Models\HttpResponse;
use App\Models\Page;
use App\Models\Screenshot;
use App\Models\User;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use DatabaseMigrations;

    public function a_user_can_only_see_http_responses_for_responses_that_are_related_to_pages_and_websites_they_own()
    {
        
    }

    /** @test */
    public function a_user_can_see_the_response_time_for_an_http_response()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $website = factory(Website::class)->create([
            'user_id' => $user->id
        ]);

        $page = factory(Page::class)->create([
            'website_id' => $website->id
        ]);

        $response = factory(HttpResponse::class)->create([
            'page_id' => $page->id,
            'ip' => '54.92.167.62',
            'response_code' => 200,
            'total_time' => 0.52,
            'domain' => 'https://racingvods.com/races',
            'request_stats_raw' => [
                'url' => 'https://racingvods.com/races',
                'content_type' => 'text/html; charset=UTF-8',
                'http_code' => 200,
                'header_size' => 954,
                'request_size' => 98,
                'filetime' => -1,
                'ssl_verify_result' => 0,
                'redirect_count' => 0,
                'total_time' => 0.518024,
                'namelookup_time' => 0.243284,
                'connect_time' => 0.290095,
                'pretransfer_time' => 0.393124,
                'size_upload' => 0,
                'size_download' => 2520,
                'speed_download' => 4864,
                'speed_upload' => 0,
                'download_content_length' => 2520,
                'upload_content_length' => -1,
                'starttransfer_time' => 0.517807,
                'redirect_time' => 0,
                'redirect_url' => '',
                'primary_ip' => '54.92.167.62',
                'certinfo' => null,
                'primary_port' => 443,
                'local_ip' => '192.168.1.3',
                'local_port' => 49403,
                'appconnect_time' => 0.393056
            ]
        ]);

        $this->get(route('responses.show', ['response' => $response]))
            ->assertStatus(200)
            ->assertSeeText($response->request_stats_raw['starttransfer_time'])
            ->assertSeeText($response->request_stats_raw['namelookup_time'])
            ->assertSeeText($response->request_stats_raw['connect_time'])
            ->assertSeeText($response->request_stats_raw['pretransfer_time'])
            ->assertSeeText($response->request_stats_raw['starttransfer_time'])
            ->assertSeeText($response->request_stats_raw['appconnect_time'])
            ->assertSeeText($response->request_stats_raw['total_time'])
            ->assertSeeText($response->request_stats_raw['primary_ip'])
            ->assertSeeText($response->request_stats_raw['url']);
    }
}