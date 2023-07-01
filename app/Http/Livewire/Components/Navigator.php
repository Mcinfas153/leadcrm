<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Navigator extends Component
{

    public $title;

    public function mount($title)
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('livewire.components.navigator');
    }
}
