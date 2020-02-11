<?php

namespace App\Jobs;

use App\Models\HttpResponse;
use App\Models\Page;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\TransferStats;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

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
        $client = resolve('HttpClient');

        try {
            $response = $client->request('GET', $this->page->full_route, [
                'on_stats' => function (TransferStats $stats) use (&$handlerStats) {
                    $handlerStats = $stats;
                },
            ]);

            //TODO Find a better way to do this
            if (App::runningUnitTests()) {
                $handlerStats = $this->setFakeTransferStats(new Request('GET', 'https://yeet.com/'), $response);
            }

            $this->saveResponse($response, $handlerStats);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $this->saveResponse($response, $handlerStats);
            }
        } catch (\Exception $exception) {
            Log::error('Error running AnalyzePage for Page Id: '.$this->page->id);
            Log::error($exception->getMessage() ?? 'Something went wrong');
        }
    }

    public function saveResponse($response, $handlerStats = [])
    {
        HttpResponse::create([
            'page_id'               => $this->page->id,
            'domain'                => $this->page->full_route,
            'response_code'         => $response->getStatusCode() ?? null,
            'ip'                    => $handlerStats->getHandlerStats()['primary_ip'] ?? null,
            'total_time'            => $handlerStats->getHandlerStats()['total_time'] ?? null,
            'headers_raw'           => json_encode($response->getHeaders(), JSON_PRETTY_PRINT) ?? null,
            'request_stats_raw'     => json_encode($handlerStats->getHandlerStats(), JSON_PRETTY_PRINT) ?? null,
        ]);
    }

    /* This is only used for unit testing */
    public function setFakeTransferStats($client, $response)
    {
        $transferTime = 0.216893;
        $handlerErrorData = 0;
        $handlerStats = [
            'url' => 'https://test.com/',
            'content_type' => 'text/html; charset=ISO-8859-1',
            'http_code' => 200,
            'header_size' => 892,
            'request_size' => 93,
            'filetime' => -1,
            'ssl_verify_result' => 0,
            'redirect_count' => 0,
            'total_time' => 0.216893,
            'namelookup_time' => 0.0051060000000001,
            'connect_time' => 0.043574,
            'pretransfer_time' => 0.131231,
            'size_upload' => 0.0,
            'size_download' => 12639.0,
            'speed_download' => 58272.0,
            'speed_upload' => 0.0,
            'download_content_length' => -1.0,
            'upload_content_length' => -1.0,
            'starttransfer_time' => 0.211116,
            'redirect_time' => 0.0,
            'redirect_url' => '',
            'primary_ip' => '216.58.194.68',
            'certinfo' => [],
            'primary_port' => 443,
            'local_ip' => '192.168.1.3',
            'local_port' => 53919,
            'appconnect_time' => 0.13117,
        ];

        return new TransferStats($client, $response, $transferTime, $handlerErrorData, $handlerStats);
    }
}
