<?php

namespace App\Http\Livewire\Pages;

use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ResetCodeConfirmation extends Component
{

    public string $resetCode;

    protected $rules = [
        'resetCode' => 'required|size:10'
    ];

    protected $messages = [
        'resetCode.required' => 'The reset code cannot be empty.',
        'resetCode.size:10' => 'The reset code is not valid.',
    ];

    public function render()
    {
        return view('livewire.pages.reset-code-confirmation')->layout('layouts.guest', [
            'title' => 'password reset code confirmation'
        ]);
    }


    public function verifyResetCode()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            
            $resetCollecttion = PasswordReset::where('reset_code', $this->resetCode)
                                            ->where('is_active', 1)
                                            ->whereBetween('created_at',[Carbon::now()->subMinute(30), Carbon::now()])
                                            ->first();

            if(empty($resetCollecttion)){

                return $this->addError('resetCode', 'Reset code is not valid or expired. Please try to reset again');
            }

            //reset code inactive
            $resetCollecttion->is_active = 0;
            $resetCollecttion->save();
            
            //log as current user
            $currentUser = User::where('email', $resetCollecttion->email)->first();
            Auth::login($currentUser);

            DB::commit();

            return redirect('/reset-password')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.PASSWORD_RESET_CODE_VALID')
            ]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }

    }
}
