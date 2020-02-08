<?php

namespace App\Observers;

use App\Assertion;
use App\AssertionResult;
use App\SslResponse;
use App\Task;
use Illuminate\Support\Facades\Log;

class AssertionObserver
{
    /**
     * Handle the assertion "created" event.
     *
     * @param  \App\Assertion  $assertion
     * @return void
     */
    public function created(Assertion $assertion)
    {
        $assertion->execute();

        Task::create([
            'taskable_type' => 'App\Assertion',
            'taskable_id' => $assertion->id,
            'frequency' => 'hourly'
        ]);
    }

    /**
     * Handle the assertion "updated" event.
     *
     * @param  \App\Assertion  $assertion
     * @return void
     */
    public function updated(Assertion $assertion)
    {
        $assertion->execute();
    }

    /**
     * Handle the assertion "deleting" event.
     *
     * @param  \App\Assertion  $assertion
     * @return void
     */
    public function deleting(Assertion $assertion)
    {
        Log::info('Deleting Assertion Id: ' . $assertion->id);

        //Delete any Results related to the assertion
        foreach ($assertion->results as $result) {
            $result->delete();
        }

        //Delete any Tasks related to the assertion
        foreach ($assertion->tasks as $task) {
            $task->delete();
        }
    }

    /**
     * Handle the assertion "restored" event.
     *
     * @param  \App\Assertion  $assertion
     * @return void
     */
    public function restored(Assertion $assertion)
    {
        Log::info('Restoring Assertion Id: ' . $assertion->id);

        //Restore any Results related to the assertion
        $results = AssertionResult::withTrashed()
            ->where('assertion_id', $assertion->id)
            ->get();

        foreach ($results as $result) {
            $result->restore();
        }

        //Restore any tasks related to the assertion
        $tasks = Task::withTrashed()
            ->where('taskable_type', 'App\Assertion')
            ->where('taskable_id', $assertion->id)
            ->get();

        foreach ($tasks as $task) {
            $task->restore();
        }
    }

    /**
     * Handle the assertion "force deleted" event.
     *
     * @param  \App\Assertion  $assertion
     * @return void
     */
    public function forceDeleted(Assertion $assertion)
    {
        //
    }
}
