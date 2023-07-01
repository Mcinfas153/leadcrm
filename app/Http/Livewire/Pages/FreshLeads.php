<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class FreshLeads extends Component
{
    public function render()
    {
        return view('livewire.pages.fresh-leads')->layout('layouts.app',[
            'title' => 'fresh leads'
        ]);
    }
}
