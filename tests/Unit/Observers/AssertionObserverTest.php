<?php

namespace Tests\Unit\Observers;

use App\Models\Assertion;
use App\Models\AssertionResult;
use App\Jobs\AnalyzeAssertion;
use App\Models\Page;
use App\Models\Task;
use App\Models\Website;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Tests\traits\MockHttpCalls;

class AssertionObserverTest extends TestCase
{
    use DatabaseMigrations, MockHttpCalls;

    /** @test */
    public function created_it_should_execute_the_assertion()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $this->expectsJobs(AnalyzeAssertion::class);

        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
        ]);
    }

    /** @test */
    public function created_it_should_create_a_recurring_task()
    {
        $this->assertCount(0, Task::where('taskable_type', \App\Models\Assertion::class)->get());

        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
        ]);

        $this->assertCount(1, Task::where('taskable_type', \App\Models\Assertion::class)->get());
    }

    /** @test */
    public function updated_it_should_execute_the_assertion()
    {
        $this->fakeHttpResponse();

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $page2 = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
        ]);

        $this->expectsJobs(AnalyzeAssertion::class);

        $assertion->refresh();
        $assertion->page_id = $page2->id;
        $assertion->save();
    }

    /** @test */
    public function deleted_it_should_delete_all_assertion_results()
    {
        $this->fakeHttpResponse();

        $this->assertCount(0, AssertionResult::all());

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
        ]);

        $this->assertCount(1, AssertionResult::all());

        $assertion->execute();

        $this->assertCount(2, AssertionResult::all());

        $assertion->refresh();
        $assertion->delete();

        $this->assertCount(0, AssertionResult::all());
    }

    /** @test */
    public function deleted_it_should_delete_all_tasks_related_to_the_assertion()
    {
        $this->fakeHttpResponse();

        $this->assertCount(0, Task::where('taskable_type', \App\Models\Assertion::class)->get());

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
        ]);

        $this->assertCount(1, Task::where('taskable_type', \App\Models\Assertion::class)->get());

        $assertion->refresh();
        $assertion->delete();

        $this->assertCount(0, Task::where('taskable_type', \App\Models\Assertion::class)->get());
    }

    /** @test */
    public function restored_it_should_restore_all_assertion_results()
    {
        $this->fakeHttpResponse();

        $this->assertCount(0, AssertionResult::all());

        $website = factory(Website::class)->create();

        $page = factory(Page::class)->create([
            'website_id' => $website->id,
        ]);

        $assertion = factory(Assertion::class)->create([
            'page_id' => $page->id,
        ]);

        $this->assertCount(1, AssertionResult::all());

        $assertion->execute();

        $this->assertCount(2, AssertionResult::all());

        $assertion->refresh();
        $assertion->delete();

        $this->assertCount(0, AssertionResult::all());

        Assertion::withTrashed()->find($assertion->id)->restore();

        $this->assertCount(3, AssertionResult::all());
    }
}
