<?php

namespace App\Http\Traits;

use App\Http\Traits\DateTrait;
use App\Models\Lead;
use App\Models\LeadActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\UserTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\NotificationTrait;
use App\Mail\LeadAssign;
use App\Models\PushNotificationBrowser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

trait LeadTrait{

    use DateTrait;
    use UserTrait;

    public static function getLeadsCountByDay(int $numberOfDays):array
    {
        $leadCounts = [];
        $days = DateTrait::getPrevieosDays($numberOfDays);
        
        foreach($days as $day){
            if(Auth::user()->user_type == config('custom.USER_ADMIN')){
                $count = Lead::where('created_by', Auth::user()->id)
                        ->whereDate('created_at', $day)
                        ->count();
            } else {
                $count = Lead::where(function($query) {
                            $query->where('created_by', Auth::user()->id)
                                ->orWhere('assign_to', Auth::user()->id);
                            })
                        ->whereDate('created_at', $day)
                        ->count();
            }
                $leadCounts[] = $count;
        }

        return $leadCounts;
    }

    public static function getEligibleReshuffleLeads():void
    {
        $organizations = DB::table('organizations')
                        ->select('organizations.*', 'reshuffle_periods.period as period')
                        ->join('reshuffle_periods', 'organizations.lead_reshuffle_period', '=', 'reshuffle_periods.id')
                        ->where(['organizations.is_active' => 1, 'organizations.lead_reshuffle' => 1])->get();

        foreach($organizations as $organization){
            
            $users = UserTrait::bestPerformer($organization->id);
            
            $leads = Lead::select('leads.*')
                        ->where('created_by', $organization->created_by)
                        ->whereBetween('leads.created_at', [localTimeConvert(config('custom.LOCAL_TIMEZONE'), Carbon::now()->subHours(72)), localTimeConvert(config('custom.LOCAL_TIMEZONE'),Carbon::now())])
                        ->get();
                        
                        // //->lazyById(100, function ($leads) {
                            foreach ($leads as $lead) {  
                                if(Carbon::parse(localTimeConvert(config('custom.LOCAL_TIMEZONE'), Carbon::now()))->diffInHours($lead->assign_time) > $organization->period){
                                    $currentLeadActivity = LeadActivity::where([['lead_id', '=', $lead->id],['user_id', '!=', $lead->created_by],])->get();
                                    if($currentLeadActivity->isEmpty()){
                                        //lead assign to most active user today or there is no one active doesn't change anything
                                        if(!$users->isEmpty()){
                                            $lead->assign_to = $users->random()->id;
                                            $lead->assign_time = localTimeConvert(config('custom.LOCAL_TIMEZONE'), Carbon::now());
                                            $lead->save();
                                            
                                            //notify agent
                                            if(config('custom.IS_MAIL_ON')){

                                                $allBrowsers = PushNotificationBrowser::where('user_id', $lead->assign_to)->get();

                                                foreach($allBrowsers as $browser){
                                                    NotificationTrait::push($browser->id, config('message.NEW_LEAD_RECIEVED'), env('APP_URL').'lead/view/'.$lead->id);
                                                
                                                }
                                                
                                                Mail::to(User::find($lead->assign_to)->email)->queue(new LeadAssign(Lead::find($lead->id)));
                                            }

                                        }                                    
                                    }
                                }
                            }
                        //});
        }
    }
}