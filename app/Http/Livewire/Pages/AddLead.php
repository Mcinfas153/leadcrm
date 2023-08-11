<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddLead extends Component
{
    public $fullname;
    public $email;
    public $phone;
    public $secondaryPhone;
    public $whatsapp;
    public $city;
    public $country;
    public $campaignName;
    public $propertyType;
    public $developer;
    public $bedroom;
    public $purpose;
    public $budget;
    public $contactTime;
    public $source;
    public $priority;
    public $status;
    public $assignedTo;
    public $inquiry;

    protected $rules = [
        'fullname' => 'required',
        'email' => 'required|email',
        'phone' => 'required',
        'campaignName' => 'required',
        'priority' => 'required',
        'status' => 'required',
    ];

    protected $messages = [
        'fullname.required' => 'The fullname cannot be empty.',
        'email.required' => 'The email address cannot be empty.',
        'email.email' => 'The email address format is not valid.',
        'phone.required' => 'The phone cannot be empty.',
        'campaignName.required' => 'The campaign name cannot be empty.',
        'priority.required' => 'The priority cannot be empty.',
        'status.required' => 'The status cannot be empty.',
    ];

    public function render()
    {
        return view('livewire.pages.add-lead', [
            'sources' => DB::table('lead_sources')->get(),
            'statuses' => DB::table('lead_statuses')->get(),
            'priorities' => DB::table('priorities')->get(),
            'types' => DB::table('lead_types')->get(),
            'agents' => DB::table('users')->where('business_id', Auth::user()->business_id)->get(),
        ])->layout('layouts.app', [
            'title' => 'add lead'
        ]);
    }

    public function addLead() {

        $this->validate();

        DB::beginTransaction();

        if(Auth::user()->user_type == config('custom.USER_ADMIN')){
            $assignTo = $this->assignedTo ?? Auth::user()->id;
        }else{
            $assignTo = Auth::user()->id;
        }

        try {
            Lead::create([
                'fullname' => $this->fullname,
                'email' => $this->email,
                'phone' => $this->phone,
                'secondary_phone' => $this->secondaryPhone,
                'whatsapp' => $this->whatsapp,
                'city' => $this->city,
                'country' => $this->country,
                'campaign_name' => $this->campaignName,
                'property_type' => $this->propertyType,
                'developer' => $this->developer,
                'bedroom' => $this->bedroom,
                'purpose' => $this->purpose,
                'budget' => $this->budget,
                'source' => $this->source,
                'contact_time' => $this->contactTime,
                'priority' => $this->priority,
                'status' => $this->status,
                'assign_to' => $assignTo,
                'inquiry' => $this->inquiry,
                'created_by' => Auth::user()->id
            ]);

            DB::commit();

            return redirect('/leads')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.LEAD_CREATED_SUCCESS')
            ]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            // dd($e->getMessage());
        }
    }
}
