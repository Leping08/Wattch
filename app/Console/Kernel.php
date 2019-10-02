<?php

namespace App\Console;

use App\Task;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Go through each task to dynamically set them up.
        /*foreach (Task::all() as $task) {
            $frequency = $task->frequency; // everyHour, everyMinute, twiceDaily etc.
            $schedule->call(function() use ($task){
                $task->taskable->execute();
            })->$frequency();
        }*/

        //$schedule->call(function (){
            //Log::info('yeet');
        //})->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
