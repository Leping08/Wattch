<?php

namespace App\Jobs;

use App\Assertion;
use App\AssertionResult;
use App\Library\Classes\Assert;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AnalyzeAssertion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * @var Assertion
     */
    public $assertion;


    /**
     * AnalyzeAssertion constructor.
     * @param Assertion $assertion
     */
    public function __construct(Assertion $assertion)
    {
        $this->assertion = $assertion;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $result = Assert::run($this->assertion->page->full_route, $this->assertion->type->method, $this->assertion->parameters);

        AssertionResult::create([
            'assertion_id' => $this->assertion->id,
            'success' => $result['status'],
            'error_message' => $result['error_message'] ?? null
        ]);
    }
}
