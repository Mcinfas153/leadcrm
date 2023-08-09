<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use App\Models\LeadStatus;
use App\Models\Note;
use App\Models\Priority;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LeadView extends Component
{
    public $leadId;
    public $fullname;
    public $phone;
    public $secondaryPhone;
    public $email;
    public $whatsapp;
    public $city;
    public $country;
    public $budget;
    public $contactTime;
    public $purpose;
    public $inquiry;
    public $campaignName;
    public $propertyType;
    public $bedroom;
    public $status;
    public $source;
    public $priority;
    public $developer;
    public $type;
    public $attachment;
    public $assignTo;
    public $lead;

    protected $rules = [
        'fullname' => 'required',
        'phone' => 'required',
        'email' => 'required'
    ];

    public function mount($leadId)
    {
        $this->leadId = $leadId;
        $lead = Lead::find($this->leadId);
        $this->lead = $lead;
        $this->fullname = $lead->fullname;
        $this->phone = $lead->phone;
        $this->secondaryPhone = $lead->secondary_phone;
        $this->email = $lead->email;
        $this->whatsapp = $lead->whatsapp;
        $this->city = $lead->city;
        $this->country = $lead->country;
        $this->budget = $lead->budget;
        $this->contactTime = $lead->contact_time;
        $this->purpose = $lead->purpose;
        $this->inquiry = $lead->inquiry;
        $this->campaignName = $lead->campaign_name;
        $this->propertyType = $lead->property_type;
        $this->bedroom = $lead->bedroom;
        $this->status = $lead->status;
        $this->source = $lead->source;
        $this->priority = $lead->priority;
        $this->developer = $lead->developer;
        $this->type = $lead->type;
        $this->attachment = $lead->attachment;
        $this->assignTo = $lead->assign_to;
    }

    public function render()
    {
        if (Auth::user()->cannot('view', $this->lead)) {
            abort(403);
        }

        return view('livewire.pages.lead-view', [
            'statusList' => LeadStatus::where('is_active', 1)->get(),
            'usersList' => User::where('business_id', Auth::user()->business_id)->get(),
            'priorityList' => Priority::where('is_active', 1)->get(),
            'notes' => DB::table('notes')->get()
        ])->layout('layouts.app', [
            'title' => 'lead view',
        ]);
    }

    public function updatedStatus($value)
    {

        DB::beginTransaction();

        try {
            
            $lead = Lead::find($this->leadId);

            $lead->status = $value;

            $lead->save();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LEAD_STATUS_CHANGE_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function updatedAssignTo($value)
    {

        DB::beginTransaction();

        try {
            
            $lead = Lead::find($this->leadId);

            $lead->assign_to = $value;

            $lead->save();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.USER_ASSIGN_CHANGE_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function updatedPriority($value)
    {

        DB::beginTransaction();

        try {
            
            $lead = Lead::find($this->leadId);

            $lead->priority = $value;

            $lead->save();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LEAD_PRIORITY_CHANGE_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function updateLead()
    {

        if (Auth::user()->cannot('update', $this->lead)) {
            abort(403);
        }

        $this->validate();

        DB::beginTransaction();

        try {
            
           Lead::find($this->leadId)
            ->update([
                'fullname' => $this->fullname,
                'email' => $this->email,
                'phone' => $this->phone,
                'secondary_phone' => $this->secondaryPhone,
                'whatsapp' => $this->whatsapp,
                'city' => $this->city,
                'country' => $this->country,
                'budget' => $this->budget,
                'contact_time' => $this->contactTime,
                'purpose' => $this->purpose,
                'inquiry' => $this->inquiry,
                'campaign_name' => $this->campaignName,
                'property_type' => $this->propertyType,
                'bedroom' => $this->bedroom,
                'source' => $this->source,
                'developer' => $this->developer
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LEAD_UPDATED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
