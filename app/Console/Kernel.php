<?php

namespace App\Console;

use App\Task;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Auth;
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
        //Login as the system user
        Auth::loginUsingId(config('auth.system_user_id'));

        // Go through each task to dynamically set them up.
        foreach (Task::all() as $task) {
            try {
                $frequency = $task->frequency; // everyHour, everyMinute, twiceDaily etc.
                $schedule->call(function() use ($task){
                    $task->taskable->execute();
                })->$frequency();
            } catch (\Exception $exception) {
                Log::error('Error executing task Id: ' . $task->id);
                Log::error($exception->toString());
            }
        }
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
