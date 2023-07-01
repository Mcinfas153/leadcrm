<?php

namespace App\Http\Livewire\Pages;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FreshLeads extends Component
{
    public function render()
    {
        return view('livewire.pages.fresh-leads',[
            'leads' => DB::table('leads')->offset(10)
                        ->limit(50)
                        ->get()
        ])->layout('layouts.app',[
            'title' => 'fresh recent leads'
        ]);
    }
}
