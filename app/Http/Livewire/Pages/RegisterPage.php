<?php

namespace App\Http\Livewire\Pages;

use App\Mail\NotifyNewUserToSP;
use App\Mail\WelcomeNewUser;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

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

            $business = Organization::create([
                'name' => $this->businessName,
                'auth_code' => Str::random(16),
                'created_by' => $user->id
            ]);

            DB::table('users')
              ->where('id', $user->id)
              ->update(['business_id' => $business->id]);

            Auth::login($user, $remember = true);

            //send welcome mail to user
            if(config('custom.IS_MAIL_ON')){
                Mail::to($user->email)->send(new WelcomeNewUser($user));
            }

            //send mail to super admin
            if(config('custom.IS_MAIL_ON')){
                Mail::to(config('custom.SP_EMAIL'))->send(new NotifyNewUserToSP($user));
            }

            DB::commit();

            return redirect('/')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.USER_REGISTER_SUCCESS'). $user->name 
            ]);
          
          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
