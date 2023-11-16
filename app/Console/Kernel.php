<?php

namespace App\Console;

use App\Classes\Automation\LeadReshuffle;
use App\Classes\Automation\ScheduleReminder;
use App\Mail\TestMail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

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
        $schedule->call(function () {
            Mail::to('mcinfas9394@gmail.com')->send(new TestMail());
        })->everyFifteenMinutes();
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
