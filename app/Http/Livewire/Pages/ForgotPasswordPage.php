<?php

namespace App\Http\Livewire\Pages;

use App\Mail\PasswordReset as MailPasswordReset;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Illuminate\Support\Str;

class ForgotPasswordPage extends Component
{

    public string $email;

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $messages = [
        'email.required' => 'The email address cannot be empty.',
        'email.email' => 'The email address format is not valid.',
    ];

    public function render()
    {
        return view('livewire.pages.forgot-password-page')->layout('layouts.guest', [
            'title' => 'forgot password'
        ]);
    }

    public function passwordReset()
    {
        $this->validate();

        DB::beginTransaction();

        $userCount = User::where('email', $this->email)->count();

        if($userCount == 0){
            return $this->addError('email', 'The email account not found in our customer database');
        }

        try {
            
            $resetRequest = PasswordReset::create([
                'email' => $this->email,
                'reset_code' => Str::random(10)
            ]);

            DB::commit();

             //send reset code to user
             if(config('custom.IS_MAIL_ON')){
                Mail::to($this->email)->queue(new MailPasswordReset($resetRequest));
             }

            return redirect('/register')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.PASSWORD_RESET_CODE_SENT_SUCCESS')
            ]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            dd($e->getMessage());

        }
    }
}
