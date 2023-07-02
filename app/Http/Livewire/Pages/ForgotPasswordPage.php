<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;

class ForgotPasswordPage extends Component
{
    public function render()
    {
        return view('livewire.pages.forgot-password-page')->layout('layouts.guest', [
            'title' => 'forgot password'
        ]);
    }
}
