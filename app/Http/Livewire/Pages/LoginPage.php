<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LoginPage extends Component
{

    public $email;
    public $password;
    public $remember;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];

    protected $messages = [
        'email.required' => 'The email address cannot be empty',
        'email.email' => 'The email address format is not valid',
        'password.required' => 'The password cannot be empty',
    ];

    public function render()
    {
        return view('livewire.pages.login-page')->layout('layouts.guest', [
            'title' => 'login'
        ]);
    }

    public function loginUser()
    {
        $validateData = $this->validate();

        try {

            if (Auth::attempt(['email' => $this->email, 'password' => $this->password, 'is_active' => 1], $this->remember)) {
                            
                session()->regenerate();
                
                return redirect('/')->with([
                    'status' => 'success',
                    'icon' => 'success',
                    'title' => config('message.USER_LOGIN_SUCCESS') 
                ]);;
                            
            }

            $this->addError('password', config('message.USER_NOT_FOUND'));
          
          } catch (\Exception $e) {

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);
          
            //dd($e->getMessage());

          }
    }
}
