<?php

namespace App\Http\Livewire\Pages;

use App\Models\Organization;
use App\Models\ReportPeriod;
use App\Models\ReshufflePeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AccountSettings extends Component
{

    public $reportViaEmail;
    public $leadReshuffle;
    public $reportPeriod;
    public $reshufflePeriod;
    public $security;
    public $automation;

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
            'reportPeriods' => ReportPeriod::where('is_active', 1)->get()
        ])->layout('layouts.app',[
            'title' => 'account settings'
        ]);
    }

    public function updatedReportViaEmail($value)
    {
        DB::beginTransaction();

        try {
            
            $organization = Organization::find(Auth::user()->business_id);
            $organization->report_via_email = $value;
            $organization->save();

            DB::commit();

            $this->reportViaEmail = $value;
            $this->automation = "show";
            $this->security = "";

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.SETTING_UPDATE_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function updatedLeadReshuffle($value)
    {
        DB::beginTransaction();

        try {
            
            $organization = Organization::find(Auth::user()->business_id);
            $organization->lead_reshuffle = $value;
            $organization->save();

            DB::commit();

            $this->leadReshuffle = $value;
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
}
