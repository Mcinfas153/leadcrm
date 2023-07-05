<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class StatusChangeModal extends Component
{
    public $lead_status;
    
    public function render()
    {
        return view('livewire.components.status-change-modal');
    }
}
