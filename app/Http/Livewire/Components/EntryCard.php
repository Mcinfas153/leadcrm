<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class EntryCard extends Component
{

    public $entry;

    public function render()
    {
        return view('livewire.components.entry-card');
    }
}
