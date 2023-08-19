<?php

namespace App\Http\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use App\Http\Traits\ActivityTrait;
use App\Mail\WelcomeNewUser;
use Illuminate\Support\Facades\Mail;

class AddUser extends Component
{

    use ActivityTrait;

    public $name;
    public $email;
    public $phone;
    public $whatsapp;
    public $designation;
    public $userType;
    public $userRole;
    public $bio;
    public $password;
    public $passwordConfirmation;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'passwordConfirmation' => 'required|same:password',
        'userType' => 'required',
        'userRole' => 'required',
    ];

    protected $messages = [
        'name.required' => 'The name cannot be empty',
        'email.required' => 'The email address cannot be empty',
        'email.email' => 'The email address format is not valid',
        'email.unique' => 'The email address already exist in our database',
        'password.required' => 'The password cannot be empty',
        'password.min' => 'The password should be minimum 6 charactors',
        'passwordConfirmation.required' => 'The confirm password cannot be empty',
        'passwordConfirmation.same' => 'Password doesn\'t match',
        'userType.required' => 'The user type cannot be empty',
        'userRole.required' => 'The user role cannot be empty',
    ];

    public function render()
    {
        return view('livewire.pages.add-user', [
            'types' => DB::table('user_types')->where('id', 3)->get(),
            'roles' => DB::table('user_roles')->whereNotIn('id', [1, 2])->get(),
        ])->layout('layouts.app', [
            'title' => 'add user'
        ]);
    }

    public function addUser() {

        if (Auth::user()->cannot('create', User::class)) {
            abort(403);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'user_type' => $this->userType,
                'user_role' => $this->userRole,
                'business_id' => Auth::user()->business_id,
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            ActivityTrait::add(Auth::user()->id,config('custom.ACTION_ADD_USER'),Auth::user()->name.' create new user called ' .$this->name);

             //notify to new user
             if(config('custom.IS_MAIL_ON')){
                Mail::to($this->email)->later(now()->addMinutes(2),new WelcomeNewUser($user));
             }

            return redirect('/users')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.USER_CREATED_SUCCESS')
            ]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
