<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use App\Models\LeadActivity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LeadActivities extends Component
{
    public $leadId;
    public $activityLimitPerPage = 10;

    public function mount($leadId)
    {
        $this->leadId = $leadId;
    }

    protected $listeners = [
        'load-more-activities' => 'loadMore',
    ];

    public function loadMore()
    {
        $this->activityLimitPerPage = $this->activityLimitPerPage + 5;
    }

    public function render()
    {

        if (Auth::user()->cannot('view', Lead::find($this->leadId))) {
            abort(403);
        }

        return view('livewire.pages.lead-activities',[
            'activities' => LeadActivity::where('lead_id', $this->leadId)
                        ->orderByDesc('created_at')
                        //->get(),
                        ->paginate($this->activityLimitPerPage),
        ])->layout('layouts.app',[
            'title' => 'lead comments & activities'
        ]);
    }
}
