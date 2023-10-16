<?php

namespace App\Console;

use App\Classes\Automation\LeadReshuffle;
use App\Classes\Automation\ScheduleReminder;
use App\Models\Lead;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
        $schedule->call(function () {
            Lead::create([
                'fullname' => 'Crone',
                'email' => 'test@test.com',
                'phone' => '908904894',
                'campaign_name' => 'Crone Test',
                'assign_to' => 2,
                'created_by' => 2
            ]);
        })->everyFifteenMinutes();
        $schedule->call(new LeadReshuffle)->hourly();
        $schedule->call(new ScheduleReminder)->everyFifteenMinutes();
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
