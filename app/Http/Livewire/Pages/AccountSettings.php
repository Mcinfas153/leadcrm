<?php

namespace App\Http\Livewire\Pages;

use App\Models\Organization;
use App\Models\ReportPeriod;
use App\Models\ReshufflePeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits;
use App\Http\Traits\ActivityTrait;
use App\Models\User;

class AccountSettings extends Component
{

    use ActivityTrait;

    public $reportViaEmail;
    public $leadReshuffle;
    public $reportPeriod;
    public $reshufflePeriod;
    public $security;
    public $automation;
    public $oldPassword;
    public $newPassword;
    public $conPassword;

    protected $listeners = [
        'reportEmail' => 'updatedReportViaEmail',
        'leadReshuffle' => 'updatedLeadReshuffle',
    ];

    public function mount()
    {
        $organization = Organization::find(Auth::user()->business_id);
        $this->reportViaEmail = $organization->report_via_email;
        $this->leadReshuffle = $organization->lead_reshuffle;
        $this->reportPeriod = $organization->report_period;
        $this->reshufflePeriod = $organization->lead_reshuffle_period;
        $this->security = "show";
    }

    public function render()
    {
        return view('livewire.pages.account-settings',[
            'reshufflePeriods' => ReshufflePeriod::where('is_active', 1)->get(),
            'reportPeriods' => ReportPeriod::where('is_active', 1)->get(),
        ])->layout('layouts.app',[
            'title' => 'account settings'
        ]);
    }

    public function updatedReportViaEmail(int $value)
    {
        
        DB::beginTransaction();

        try {
            
            $organization = Organization::find(Auth::user()->business_id);
            $organization->report_via_email = !$value;
            $organization->save();

            DB::commit();

            $this->reportViaEmail = !$value;
            $this->automation = "show";
            $this->security = "";

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.SETTING_UPDATE_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function updatedLeadReshuffle(int $value)
    {
        DB::beginTransaction();

        try {
            
            $organization = Organization::find(Auth::user()->business_id);
            $organization->lead_reshuffle = !$value;
            $organization->save();

            DB::commit();

            $this->leadReshuffle = !$value;
            $this->automation = "show";
            $this->security = "";

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.SETTING_UPDATE_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function updatedReportPeriod($value)
    {
        DB::beginTransaction();

        try {
            
            $organization = Organization::find(Auth::user()->business_id);
            $organization->report_period = $value;
            $organization->save();

            DB::commit();

            $this->reportPeriod = $value;
            $this->automation = "show";
            $this->security = "";

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.SETTING_UPDATE_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function updatedReshufflePeriod($value)
    {
        DB::beginTransaction();

        try {
            
            $organization = Organization::find(Auth::user()->business_id);
            $organization->lead_reshuffle_period = $value;
            $organization->save();

            DB::commit();

            $this->reshufflePeriod = $value;
            $this->automation = "show";
            $this->security = "";

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.SETTING_UPDATE_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function changePassword()
    {
        $validatedData = $this->validate(
            [
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6',
            'conPassword' => 'required|same:newPassword',
            ],
            [
                'oldPassword.required' => 'The :attribute cannot be empty.',
                'newPassword.required' => 'The :attribute cannot be empty.',
                'newPassword.min:6' => 'The :attribute should be minimum 6 charactors.',
                'conPassword.required' => 'The :attribute cannot be empty.',
                'conPassword.same:newPassword' => 'New password doesn\'t match with confirm password.',
            ],
            [
                'oldPassword' => 'current password',
                'newPassword' => 'new password',
                'conPassword' => 'confirm password'
            ]
        );

        if (Hash::check($this->oldPassword, Auth::user()->password)) {
            
            DB::beginTransaction();

            try {
                
                $user = User::find(Auth::user()->id);
                $user->password = Hash::make($this->newPassword);
                $user->save();

                $this->oldPassword = $this->newPassword = $this->conPassword = null;
    
                DB::commit();
    
                ActivityTrait::add(Auth::user()->id,config('custom.ACTION_CHANGE_PASSWORD'),Auth::user()->name.' change his password');
    
                $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.USER_PASSWORD_CHANGE_SUCCESS')]);
    
              } catch (\Exception $e) {
    
                DB::rollBack();
    
                $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);
    
            }

        } else {
            $this->addError('conPassword', config('message.USER_PASSWORD_CHANGE_FAILED'));
        } 

        $this->automation = "";
        $this->security = "show";
    }
}
