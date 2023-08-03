<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class AccountSettings extends Component
{
    public function render()
    {
        return view('livewire.pages.account-settings')->layout('layouts.app',[
            'title' => 'account settings'
        ]);
    }
}
