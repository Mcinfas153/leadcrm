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
use App\Http\Traits\ActivityTrait;
use App\Models\LeadActivity;
use App\Models\LeadEntry;
use App\Models\Scheduler;
use App\Models\SchedulerType;
use Carbon\Carbon;
use Livewire\WithPagination;

class LeadView extends Component
{

    use ActivityTrait;
    use WithPagination;

    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';

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
    public $type;
    public $bedroom;
    public $status;
    public $source;
    public $priority;
    public $developer;
    public $propertyType;
    public $attachment;
    public $assignTo;
    public $lead;
    public $note;
    public $reminderTime;
    public $reminderNote;
    public $reminderType;
    public $entryType;
    public $entryNote;
    public $entryTime;
    public $entryResponse;

    protected $rules = [
        'fullname' => 'required',
        'phone' => 'required',
        'email' => 'required'
    ];

    protected $listeners = [
        'deleteNote' => 'deleteNote',
        'deleteAllActivities' => 'deleteAllActivities',
        'deleteAllComments' => 'deleteAllComments',
        'setReminderTime' => 'setReminderTime',
        'setEntryTime' => 'setEntryTime'
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
        $this->type = $lead->type;
        $this->bedroom = $lead->bedroom;
        $this->status = $lead->status;
        $this->source = $lead->source;
        $this->priority = $lead->priority;
        $this->developer = $lead->developer;
        $this->type = $lead->type;
        $this->attachment = $lead->attachment;
        $this->assignTo = $lead->assign_to;

        if (Auth::user()->cannot('view', $this->lead)) {
            abort(403);
        }

        ActivityTrait::add(Auth::user()->id, config('custom.ACTION_OPEN_LEAD'),Auth::user()->name.' open the lead', $this->leadId);

    }

    public function render()
    {

        return view('livewire.pages.lead-view', [
            'statusList' => LeadStatus::where('is_active', 1)->get(),
            'usersList' => User::where('business_id', Auth::user()->business_id)->get(),
            'priorityList' => Priority::where('is_active', 1)->get(),
            'notes' => Note::where('lead_id', $this->leadId)->orderByDesc('created_at')->paginate(4),
            'leadActivities' => LeadActivity::where('lead_id', $this->leadId)->orderByDesc('created_at')->paginate(10 ,['*'], 'commentsPage'),
            'types' => DB::table('lead_types')->get(),
            'schedulerTypes' => SchedulerType::where('is_active', 1)->get()
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

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_CHANGE_STATUS'),Auth::user()->name.' update lead status', $this->leadId);

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

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_ASSIGN_USER'),Auth::user()->name.' assign the lead', $this->leadId);

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

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_EDIT_LEAD'),Auth::user()->name.' update the lead', $this->leadId);

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
                'type' => $this->type,
                'bedroom' => $this->bedroom,
                'source' => $this->source,
                'developer' => $this->developer
            ]);

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_EDIT_LEAD'),Auth::user()->name.' update the lead', $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LEAD_UPDATED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function deleteNote($noteId)
    {
        if (Auth::user()->cannot('delete', Note::find($noteId))) {
            abort(403);
        }

        DB::beginTransaction();

        try {

            Note::find($noteId)->delete();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.NOTE_DELETED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function addComment()
    {

        $this->validate();
    
        DB::beginTransaction();

        try {

            Note::create([
                'note' => $this->note,
                'lead_id' =>  $this->leadId,
                'created_by' => Auth::user()->id
            ]);

            DB::commit();

            $this->note = "";

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_DELETE_LEAD'),Auth::user()->name.' leave a note', $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.NOTE_ADDED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function deleteAllActivities($leadId)
    {
        if (Auth::user()->cannot('massDelete', LeadActivity::class)) {
            abort(403);
        }

        DB::beginTransaction();

        try {

            DB::table('lead_activities')->where('lead_id', $leadId)->delete();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.ACTIVITIES_DELETED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function deleteAllComments($leadId)
    {

        if (Auth::user()->cannot('massDelete', Note::class)) {
            abort(403);
        }

        DB::beginTransaction();

        try {

            DB::table('notes')->where('lead_id', $leadId)->delete();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.NOTES_DELETED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function setReminderTime($pickedDate)
    {
        $this->reminderTime = $pickedDate;
    }

    public function setEntryTime($pickedDate)
    {
        $this->entryTime = $pickedDate;
    }

    public function addReminder()
    {
        $this->validate(
            [
                'reminderType' => 'required',
                'reminderNote' => 'required'
            ],
            [
                'reminderType.required' => 'The :attribute cannot be empty.',
                'reminderNote.required' => 'The :attribute cannot be empty.',
            ],
            [
                'reminderType' => 'reminder type',
                'reminderNote' => 'reminder note'
            ]
        );

        DB::beginTransaction();

        try {

            Scheduler::create([
                'reminder_time' => $this->reminderTime != null? $this->reminderTime : Carbon::now()->tz(config('custom.LOCAL_TIMEZONE'))->toDateTimeString(),
                'lead_id' => $this->leadId,
                'owner' => Auth::user()->id,
                'type' => $this->reminderType,
                'note' => $this->reminderNote
            ]);

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_SET_REMINDER'),Auth::user()->name.' set a reminder for lead ID: '.$this->leadId, $this->leadId);

            $this->reminderNote = $this->reminderType = null;
            
            $this->dispatchBrowserEvent('modalClose');

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.REMINDER_ADDED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            dd($e->getMessage());

        }
    }

    public function addEntry()
    {

        $this->validate(
            [
                'entryType' => 'required',
                'entryNote' => 'required',
                'entryResponse' => 'required'
            ],
            [
                'entryType.required' => 'The :attribute cannot be empty.',
                'entryNote.required' => 'The :attribute cannot be empty.',
                'entryResponse.required' => 'The :attribute cannot be empty.',
            ],
            [
                'entryType' => 'entry type',
                'entryNote' => 'entry note',
                'entryResponse' => 'response'
            ]
        );

        DB::beginTransaction();

        try {

            LeadEntry::create([
                'lead_id' => $this->leadId,
                'user_id' => Auth::user()->id,
                'type' => $this->entryType,
                'entry_time' => $this->entryTime != null? $this->entryTime : Carbon::now()->tz(config('custom.LOCAL_TIMEZONE'))->toDateTimeString(),
                'note' => $this->entryNote,
                'response' => $this->entryResponse
            ]);

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_ADD_ENTRY'),Auth::user()->name.' add an '.$this->entryType.' entry for lead ID: '.$this->leadId, $this->leadId);

            $this->entryNote = $this->entryResponse = $this->entryType = null;

            $this->dispatchBrowserEvent('modalClose');

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.ENTRY_ADDED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            dd($e->getMessage());

        }
    }
}
