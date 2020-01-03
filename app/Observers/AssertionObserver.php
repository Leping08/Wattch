<?php

namespace App\Observers;

use App\Assertion;
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
     * Handle the assertion "deleted" event.
     *
     * @param  \App\Assertion  $assertion
     * @return void
     */
    public function deleted(Assertion $assertion)
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
