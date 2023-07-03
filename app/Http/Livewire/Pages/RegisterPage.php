<?php

namespace App\Http\Livewire\Pages;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;

class RegisterPage extends Component
{

    public $userName;
    public $email;
    public $password;
    public $confirmPass;
    public $businessName;

    protected $rules = [
        'userName' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'confirmPass' => 'required|same:password',
        'businessName' => 'required',
    ];

    protected $messages = [
        'userName.required' => 'The name cannot be empty',
        'email.required' => 'The email address cannot be empty',
        'email.email' => 'The email address format is not valid',
        'email.unique' => 'The email address already exist in our database',
        'password.required' => 'The password cannot be empty',
        'password.min' => 'The password should be minimum 6 charactors',
        'confirmPass.required' => 'The confirm password cannot be empty',
        'confirmPass.same' => 'Password doesn\'t match',
        'businessName.required' => 'The business name cannot be empty',
    ];

    public function render()
    {
        return view('livewire.pages.register-page')->layout('layouts.guest', [
            'title' => 'register'
        ]);
    }

    public function registerUser()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            
            $user = User::create([
                'name' => $this->userName,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'user_type' => config('custom.USER_ADMIN'),
                'user_role' => config('custom.USER_ADMIN_ROLE')
            ]);

            Organization::create([
                'name' => $this->businessName,
                'auth_code' => Str::random(16),
                'created_by' => $user->id
            ]);
           
            DB::commit();

            Auth::login($user, $remember = true);

            return redirect('/')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.USER_REGISTER_SUCCESS'). $user->name 
            ]);;
          
          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);
          
            dd($e->getMessage());

        }
    }
}
