<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class ActivityPanel extends Component
{

    public $activity;

    public function render()
    {
        return view('livewire.components.activity-panel');
    }
}
