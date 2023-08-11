<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class BusinessInactive extends Component
{
    public function render()
    {
        return view('livewire.pages.business-inactive')->layout('layouts.app',[
            'title' => 'business inactive'
        ]);
    }
}
