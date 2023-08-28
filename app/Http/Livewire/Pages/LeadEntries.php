<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeadEntry;
use App\Models\Scheduler;
use App\Models\SchedulerType;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LeadEntries extends Component
{

    public int $leadId;

    public function mount($leadId)
    {
        $this->leadId = $leadId;
    }

    public function render()
    {

        if(Auth::user()->user_type == config('custom.USER_ADMIN')){
            $schedulers = Scheduler::where('lead_id', $this->leadId)->orderByDesc('reminder_time')->get();
            $entries = LeadEntry::where('lead_id', $this->leadId)->orderByDesc('entry_time')->get();
        } else {
            $schedulers = Scheduler::where('lead_id', $this->leadId)->where('owner', Auth::user()->id)->orderByDesc('reminder_time')->get();
            $entries = LeadEntry::where('lead_id', $this->leadId)->where('user_id', Auth::user()->id)->orderByDesc('entry_time')->get();
        }

        return view('livewire.pages.lead-entries',[
            'schedulers' => $schedulers,
            'entries' => $entries,
            'schedulerTypes' => SchedulerType::where('is_active', 1)->get()
        ])->layout('layouts.app',[
            'title' => 'lead enrties & schedules'
        ]);
    }
}
