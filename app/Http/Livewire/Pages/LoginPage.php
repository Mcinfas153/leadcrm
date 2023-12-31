<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\ActivityTrait;

class LoginPage extends Component
{

    use ActivityTrait;

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

                ActivityTrait::add(Auth::user()->id, config('custom.ACTION_LOGIN'),Auth::user()->name.' logged in');
                
                return redirect('/')->with([
                    'status' => 'success',
                    'icon' => 'success',
                    'title' => config('message.USER_LOGIN_SUCCESS'). Auth::user()->name,
                ]);
                            
            }

            $this->addError('password', config('message.USER_NOT_FOUND'));
          
          } catch (\Exception $e) {

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
