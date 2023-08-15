<?php

namespace App\Http\Livewire\Pages;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AddUser extends Component
{
    public $name;
    public $email;
    public $phone;
    public $whatsapp;
    public $designation;
    public $type;
    public $role;
    public $bio;
    public $password;
    public $passwordConfirmation;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'passwordConfirmation' => 'required|same:password',
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
    ];

    public function render()
    {
        return view('livewire.pages.add-user', [
            'types' => DB::table('user_types')->get(),
            'roles' => DB::table('user_roles')->get(),
        ])->layout('layouts.app', [
            'title' => 'add user'
        ]);
    }

    public function addUser() {
        $this->validate();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone,
                'whatsapp' => $this->whatsapp,
                'designation' => $this->designation,
                'bio' => $this->bio,
                'user_type' => config('custom.USER_ADMIN'),
                'user_role' => config('custom.USER_ADMIN_ROLE'),
                'business_id' => Auth::user()->business_id,
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            return redirect('/')->with([
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
