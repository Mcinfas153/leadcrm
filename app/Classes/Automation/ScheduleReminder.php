<?php

namespace App\Classes\Automation;

use App\Http\Traits\SchedulerTrait;
use App\Mail\SendTaskReminder;
use App\Models\Scheduler;
use App\Notifications\SendReminder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use PhpParser\Node\Stmt\TryCatch;

class ScheduleReminder{

    use SchedulerTrait;

    public function __invoke()
    {
       $schedulers = SchedulerTrait::getUpcomingSchedules();
       
       foreach($schedulers as $scheduler){

            $user = $scheduler->user;
            // check notification type
            if($scheduler->reminderType->id == config('custom.REMINDER_TYPE_EMAIL')){

                DB::beginTransaction();

                try {
                    
                    Mail::to($scheduler->user->email)->send(new SendTaskReminder($scheduler));

                    $reminder = Scheduler::find($scheduler->id);

                    $reminder->is_active = 0;

                    $reminder->save();

                    DB::commit();
        
                } catch (\Exception $e) {
        
                    DB::rollBack();
        
                }
                        
            }
       }
    }
}