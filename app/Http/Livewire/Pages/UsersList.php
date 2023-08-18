<?php

namespace App\Http\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ActivityTrait;

class UsersList extends Component
{
    use WithPagination;
    use ActivityTrait;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'changeUserStatus','deleteUser',
    ];

    public function render()
    {
        return view('livewire.pages.users-list', [
            'users' => User::where('created_by', Auth::user()->id)->paginate(10),
        ])->layout('layouts.app',[
            'title' => 'users'
        ]);
    }

    function changeUserStatus($userId, $currentStatus)
    {
        DB::beginTransaction();

        try {
            
            $user = User::find($userId);
            $user->is_active = !$currentStatus;
            $user->save();

            DB::commit();

            ActivityTrait::add(Auth::user()->id,config('custom.ACTION_MODIFY_USER'),Auth::user()->name.' updated user status on ' .$user->name);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.USER_STATUS_UPDATED_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    function deleteUser($userId)
    {
        DB::beginTransaction();

        try {
            
            $user = User::find($userId);

            ActivityTrait::add(Auth::user()->id,config('custom.ACTION_DELETE_USER'),Auth::user()->name.' delete user called ' .$user->name);

            $user->delete();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.USER_STATUS_UPDATED_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
