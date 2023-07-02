<?php

namespace App\Http\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends Component
{
    public function render()
    {
        return view('livewire.components.header');
    }

    public function userLogout()
    {
        Auth::logout();
 
        session()->invalidate();
        
        session()->regenerateToken();
        
        return redirect()->route('login');
    }
}
