<?php

namespace App\Console;

use App\Classes\Automation\LeadReshuffle;
use App\Classes\Automation\ScheduleReminder;
use App\Classes\Automation\Test;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(new LeadReshuffle)->hourly();
        $schedule->call(new ScheduleReminder)->everyFifteenMinutes();
        //$schedule->call(new Test)->everyFifteenMinutes();
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
