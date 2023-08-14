<?php

namespace App\Http\Livewire\Components;

use App\Models\UserActivity;
use Livewire\Component;

class DataBox extends Component
{

    public $activityStat;
    public $stat;
    public $actionName;

    public function render()
    {
        return view('livewire.components.data-box');
    }
}
