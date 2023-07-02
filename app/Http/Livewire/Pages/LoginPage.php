<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class LoginPage extends Component
{
    public function render()
    {
        return view('livewire.pages.login-page')->layout('layouts.guest', [
            'title' => 'login'
        ]);
    }
}
