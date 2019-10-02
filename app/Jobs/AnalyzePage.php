<?php

namespace App\Jobs;

use App\HttpResponse;
use App\Page;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\TransferStats;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AnalyzePage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Page
     */
    private $page;

    /**
     * Create a new job instance.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
    }


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try{
            $response = (new Client(['http_errors' => false]))->request('GET', $this->page->full_route, [
                'on_stats' => function (TransferStats $stats) use (&$handlerStats) {
                    $handlerStats = $stats;
                }
            ]);

            HttpResponse::create([
                'page_id'               => $this->page->id,
                'domain'                => $this->page->full_route,
                'response_code'         => $response->getStatusCode(),
                'ip'                    => $handlerStats->getHandlerStats()['primary_ip'],
                'total_time'            => $handlerStats->getHandlerStats()['total_time'],
                'headers_raw'           => json_encode($response->getHeaders()),
                'request_stats_raw'     => json_encode($handlerStats->getHandlerStats())
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                HttpResponse::create([
                    'page_id'               => $this->page->id,
                    'domain'                => $this->page->full_route,
                    'response_code'         => $response->getStatusCode(),
                    'ip'                    => $handlerStats->getHandlerStats()['primary_ip'],
                    'total_time'            => $handlerStats->getHandlerStats()['total_time'],
                    'headers_raw'           => json_encode($response->getHeaders()),
                    'request_stats_raw'     => json_encode($handlerStats->getHandlerStats())
                ]);
            } else {
                HttpResponse::create([
                    'page_id'               => null,
                    'domain'                => null, //TODO get the domain to show up here
                    'response_code'         => 0,
                    'ip'                    => 0,
                    'total_time'            => 0,
                    'headers_raw'           => [],
                    'request_stats_raw'     => []
                ]);
            }
        }

        //if($this->page->id === $this->page->website->home_page->id) {
        CaptureScreenshot::dispatchNow($this->page);
        //}
    }
}
