<?php

namespace App\Jobs;

use App\Models\SslResponse;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Spatie\SslCertificate\SslCertificate;

class AnalyzeWebsite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Website
     */
    private $website;

    /**
     * Create a new job instance.
     *
     * @param Website $website
     */
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            //TODO Make this a mock
            if (App::runningUnitTests()) {
                SslResponse::create([
                    'website_id' => $this->website->id,
                    'ssl_valid' => 1,
                    'ssl_expires_in' => 30,
                    'ssl_raw' => [],
                ]);
            } else {
                $certificate = SslCertificate::createForHostName($this->website->domain);

                SslResponse::create([
                    'website_id' => $this->website->id,
                    'ssl_valid' => $certificate->isValid(),
                    'ssl_expires_in' => $certificate->expirationDate()->diffInDays(),
                    'ssl_raw' => $certificate,
                ]);
            }
        } catch (\Exception $e) {
            SslResponse::create([
                'website_id' => $this->website->id,
                'ssl_valid' => 0,
                'ssl_expires_in' => 0,
                'ssl_raw' => json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT),
            ]);
        }
    }
}
