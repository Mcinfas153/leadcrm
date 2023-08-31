<?php

namespace App\Http\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ResetPassword extends Component
{

    public string $newPassword, $confirmPassword;

    protected $rules = [
        'newPassword' => 'required|min:6',
        'confirmPassword' => 'required|same:newPassword',
    ];

    protected $messages = [
        'newPassword.required' => 'The new password cannot be empty',
        'newPassword.min' => 'The new password should be minimum 6 charactors',
        'confirmPassword.required' => 'The confirm password cannot be empty',
        'confirmPassword.same' => 'Passwords doesn\'t match',
    ];

    public function render()
    {
        return view('livewire.pages.reset-password')->layout('layouts.guest', [
            'title' => 'reset password'
        ]);
    }

    public function resetPassword()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            
            $user = User::find(Auth::id())->update([
                'password' => Hash::make($this->newPassword)
            ]);

            DB::commit();

            return redirect('/')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.PASSWORD_RESET_SUCCESS')
            ]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
