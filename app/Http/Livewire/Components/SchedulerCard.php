<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class SchedulerCard extends Component
{

    public $scheduler;

    public function render()
    {
        return view('livewire.components.scheduler-card');
    }
}
