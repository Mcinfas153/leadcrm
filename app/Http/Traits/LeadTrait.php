<?php

namespace App\Http\Traits;
use App\Http\Traits\DateTrait;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;

trait LeadTrait{

    use DateTrait;

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
}