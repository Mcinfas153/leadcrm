<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class Dashboard extends Component
{

    public function mount()
    {
        
    }

    public function render()
    {
        return view('livewire.pages.dashboard',[
            'dailyLeads' => [20, 15, 30, 25, 10, 15],
            'monthDates' => [1, 2, 3, 4, 5, 6]
        ])->layout('layouts.app', [
            'title' => 'dashboard'
        ]);
    }
}
