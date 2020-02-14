<?php

namespace App\Console;

use App\Models\Task;
use App\Models\User;
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
        $schedule->command('telescope:prune')->daily();

        // Go through each task to dynamically set them up.
        $tasks = Task::cursor();

        foreach ($tasks as $task) {
            $frequency = $task->frequency; // everyHour, everyMinute, twiceDaily etc.
            $schedule->call(function () use ($task) {
                try {
                    Log::info('Executing task Id: '.$task->id);
                    $task->taskable->execute();
                } catch (\Exception $exception) {
                    Log::error('Error executing task Id: '.$task->id);
                }
            })->$frequency();
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
