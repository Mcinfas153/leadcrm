<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{

    public function mount()
    {
        
    }

    public function render()
    {
        if(Auth::user()->user_type == config('custom.USER_ADMIN')){

        $newLeadsCount = Lead::where('created_by', Auth::user()->id)
                        ->where('status', config('custom.LEAD_STATUS_NEW'))
                        ->count();

        $todayLeadsCount = Lead::where('created_by', Auth::user()->id)
                            ->whereDate('created_at', timeZoneChange(config('custom.LOCAL_TIMEZONE'))->toDateString())
                            ->count();

        $followingLeadCount = Lead::where('created_by', Auth::user()->id)
                            ->where(function ($query) {
                                $query->where('status', config('custom.LEAD_STATUS_FOLLOWINGUP'))
                                    ->orWhere('status', config('custom.LEAD_STATUS_SENT_EMAIL'))
                                    ->orWhere('status', config('custom.LEAD_STATUS_SENT_WHATSAPP'))
                                    ->orWhere('status', config('custom.LEAD_STATUS_SITE_VISIT'))
                                    ->orWhere('status', config('custom.LEAD_STATUS_SETUP_MEETING'))
                                    ->orWhere('status', config('custom.LEAD_STATUS_MEETING_DONE'))
                                    ->orWhere('status', config('custom.LEAD_STATUS_SITE_VISIT_DONE'))
                                    ->orWhere('status', config('custom.LEAD_STATUS_FOLLOWUP_AFTER_MEETING'));
                            })                            
                            ->count();

        $totalLeadsCount = Lead::where('created_by', Auth::user()->id)
                            ->count();

        $closeDealsCount = Lead::where('created_by', Auth::user()->id)
        ->where('status', config('custom.LEAD_STATUS_DEAL_CLOSED'))
        ->count();


        } else if(Auth::user()->user_type == config('custom.USER_NORMAL')){

            $newLeadsCount = Lead::where('status', config('custom.LEAD_STATUS_NEW'))
                            ->where(function($query) {
                            $query->where('created_by', Auth::user()->id)
                                    ->orWhere('assign_to', Auth::user()->id);
                            })
                            ->count();

            $todayLeadsCount = Lead::whereDate('created_at', timeZoneChange(config('custom.LOCAL_TIMEZONE'))->toDateString())
                            ->where(function($query) {
                            $query->where('created_by', Auth::user()->id)
                                  ->orWhere('assign_to', Auth::user()->id);
                            })
                            ->count();

            $followingLeadCount = Lead::where(function($query) {
                $query->where('created_by', Auth::user()->id)
                      ->orWhere('assign_to', Auth::user()->id);
                })
                ->where(function ($query) {
                    $query->where('status', config('custom.LEAD_STATUS_FOLLOWINGUP'))
                        ->orWhere('status', config('custom.LEAD_STATUS_SENT_EMAIL'))
                        ->orWhere('status', config('custom.LEAD_STATUS_SENT_WHATSAPP'))
                        ->orWhere('status', config('custom.LEAD_STATUS_SITE_VISIT'))
                        ->orWhere('status', config('custom.LEAD_STATUS_SETUP_MEETING'))
                        ->orWhere('status', config('custom.LEAD_STATUS_MEETING_DONE'))
                        ->orWhere('status', config('custom.LEAD_STATUS_SITE_VISIT_DONE'))
                        ->orWhere('status', config('custom.LEAD_STATUS_FOLLOWUP_AFTER_MEETING'));
                })                            
                ->count();

        $totalLeadsCount = Lead::where(function($query) {
                        $query->where('created_by', Auth::user()->id)
                            ->orWhere('assign_to', Auth::user()->id);
                        })
                        ->count();

        $closeDealsCount = Lead::where(function($query) {
                        $query->where('created_by', Auth::user()->id)
                            ->orWhere('assign_to', Auth::user()->id);
                        })
                        ->where('status', config('custom.LEAD_STATUS_DEAL_CLOSED'))
                        ->count();

        } else {

            $newLeadsCount = 0;
            $todayLeadsCount = 0;
            $followingLeadCount = 0;
            $totalLeadsCount = 0;
            $closeDealsCount = 0;
        }

        return view('livewire.pages.dashboard',[
            'newLeadsCount' => $newLeadsCount,
            'todayLeadsCount' => $todayLeadsCount,
            'followingLeadCount' => $followingLeadCount,
            'totalLeadsCount' => $totalLeadsCount,
            'closeDealsCount' => $closeDealsCount,
            'dailyLeads' => [20, 15, 30, 25, 10, 15],
            'monthDates' => [1, 2, 3, 4, 5, 6]
        ])->layout('layouts.app', [
            'title' => 'dashboard'
        ]);
    }
}
