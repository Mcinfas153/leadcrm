<?php

namespace App\Http\Livewire\Pages;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.pages.users-list', [
            'users' => User::paginate(3),
        ])->layout('layouts.app',[
            'title' => 'users list'
        ]);
    }
}
