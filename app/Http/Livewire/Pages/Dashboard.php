<?php

namespace App\Http\Livewire\Pages;

use App\Charts\DailyLeadsChart;
use App\Charts\MonthlyLeadsChart;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Http\Traits\DateTrait;
use App\Models\CloseDeal;

class Dashboard extends Component
{

    use DateTrait;

    public function mount()
    {

    }

    public function render(DailyLeadsChart $chart, MonthlyLeadsChart $monthlyLeadChart)
    {

        if(Auth::user()->user_type == config('custom.USER_ADMIN')){

        $newLeadsCount = Lead::where('created_by', Auth::user()->id)
                        ->where('status', config('custom.LEAD_STATUS_NEW'))
                        ->where('is_migrate_lead', 0)
                        ->count();

        $todayLeadsCount = Lead::where('created_by', Auth::user()->id)
                            ->where('is_migrate_lead', 0)
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

        $closeDealsCount = CloseDeal::where('business_id', Auth::user()->business_id)
                                    ->count();

        $latesLeads = Lead::where('created_by', Auth::user()->id)
                            ->where('is_migrate_lead', 0)
                            ->limit(5)
                            ->latest()
                            ->get();


        } else if(Auth::user()->user_type == config('custom.USER_NORMAL')){

            $newLeadsCount = Lead::where('status', config('custom.LEAD_STATUS_NEW'))
                            ->where('is_migrate_lead', 0)
                            ->where(function($query) {
                            $query->where('created_by', Auth::user()->id)
                                    ->orWhere('assign_to', Auth::user()->id);
                            })
                            ->count();

            $todayLeadsCount = Lead::whereDate('created_at', timeZoneChange(config('custom.LOCAL_TIMEZONE'))->toDateString())
                            ->where('is_migrate_lead', 0)
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

        $closeDealsCount = CloseDeal::where('commision_details->user_id', Auth::user()->id)
                        ->count();

        $latesLeads = Lead::where(function($query) {
                        $query->where('created_by', Auth::user()->id)
                            ->orWhere('assign_to', Auth::user()->id);
                        })
                        ->where('is_migrate_lead', 0)
                        ->limit(5)
                        ->latest()
                        ->get();

        } else {

            $newLeadsCount = 0;
            $todayLeadsCount = 0;
            $followingLeadCount = 0;
            $totalLeadsCount = 0;
            $closeDealsCount = 0;
            $latesLeads = [];
        }

        return view('livewire.pages.dashboard',[
            'newLeadsCount' => $newLeadsCount,
            'todayLeadsCount' => $todayLeadsCount,
            'followingLeadCount' => $followingLeadCount,
            'totalLeadsCount' => $totalLeadsCount,
            'closeDealsCount' => $closeDealsCount,
            'chart' => $chart->build(),
            'monthlyLeadChart' => $monthlyLeadChart->build(),
            'latestLeads' => $latesLeads
        ])->layout('layouts.app', [
            'title' => 'dashboard'
        ]);
    }
}
