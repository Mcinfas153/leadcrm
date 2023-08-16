<?php

namespace App\Http\Traits;

use App\Http\Traits\DateTrait;
use App\Models\Lead;
use App\Models\LeadActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;
use App\Http\Traits\UserTrait;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

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
                        ->whereBetween('leads.created_at', [Carbon::now()->subHours(72), Carbon::now()])
                        ->get();
                        // //->lazyById(100, function ($leads) {
                            foreach ($leads as $lead) {                                
                                if(Carbon::parse($lead->assign_to)->diffInHours(Carbon::now()) > $organization->period){
                                $currentLeadActivity = LeadActivity::where([['lead_id', '=', $lead->id],['user_id', '!=', $lead->created_by],])->get();
                                    if($currentLeadActivity->isEmpty()){
                                        //lead assign to most active user today or there is no one active doesn't change anything
                                        if(!$users->isEmpty()){
                                            $lead->assign_to = $users->random()->id;
                                            $lead->save();
                                        }                                    
                                    }
                                }
                            }
                        //});
        }
    }
}