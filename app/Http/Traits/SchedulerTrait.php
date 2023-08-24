<?php

namespace App\Http\Traits;

use App\Models\Scheduler;
use Carbon\Carbon;

trait SchedulerTrait{

    public static function getUpcomingSchedules()
    {
        return Scheduler::where('is_active', 1)
                        ->whereBetween('reminder_time', [Carbon::now()->tz(config('custom.LOCAL_TIMEZONE')),Carbon::now()->tz(config('custom.LOCAL_TIMEZONE'))->addSecond(60)])
                        ->get();
    }

}