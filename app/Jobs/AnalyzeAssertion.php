<?php

namespace App\Jobs;

use App\Assertion;
use App\AssertionResult;
use App\Library\Classes\Assert;
use App\Notifications\AssertionFailed;
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

        $assertionResult = AssertionResult::create([
            'assertion_id' => $this->assertion->id,
            'success' => $result['status'],
            'error_message' => $result['error_message'] ?? null
        ]);

        //If the assertion failed notify the user through the assertion failed notification class
        if(!$result['status']) {
            $user = $this->assertion->page->website->user;
            $user->notify(new AssertionFailed($assertionResult));
        }
    }
}
