<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\User;
use Livewire\Component;

class LeadView extends Component
{
    public $lead;

    public function render()
    {
        return view('livewire.pages.lead-view', [
            'status' => LeadStatus::all(),
            'users' => User::all(),
        ])->layout('layouts.app', [
            'title' => 'lead view',
        ]);
    }

    public function mount($leadId)
    {
        $this->lead = Lead::find($leadId);
    }
}
