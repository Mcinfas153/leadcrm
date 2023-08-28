<?php

namespace App\Http\Livewire\Pages;

use App\Models\LeadEntry;
use App\Models\Scheduler;
use App\Models\SchedulerType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Http\Traits\ActivityTrait;
use Carbon\Carbon;
use Livewire\WithPagination;

class LeadEntries extends Component
{

    use ActivityTrait;
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';

    public int $leadId;
    public $reminderTime;
    public $reminderNote;
    public $reminderType;
    public $entryType;
    public $entryNote;
    public $entryTime;
    public $entryResponse;

    protected $listeners = [
        'deleteReminder' => 'deleteReminder',
        'deleteEntry' => 'deleteEntry',
        'deleteAllReminders' => 'deleteAllReminders',
        'deleteAllEntries' => 'deleteAllEntries',
        'setReminderTime' => 'setReminderTime',
        'setEntryTime' => 'setEntryTime'
    ];

    public function mount($leadId)
    {
        $this->leadId = $leadId;
    }

    public function render()
    {

        if(Auth::user()->user_type == config('custom.USER_ADMIN')){
            $schedulers = Scheduler::where('lead_id', $this->leadId)->orderByDesc('reminder_time')->get();
            $entries = LeadEntry::where('lead_id', $this->leadId)->orderByDesc('entry_time')->get();
        } else {
            $schedulers = Scheduler::where('lead_id', $this->leadId)->where('owner', Auth::user()->id)->orderByDesc('reminder_time')->get();
            $entries = LeadEntry::where('lead_id', $this->leadId)->where('user_id', Auth::user()->id)->orderByDesc('entry_time')->get();
        }

        return view('livewire.pages.lead-entries',[
            'schedulers' => $schedulers,
            'entries' => $entries,
            'schedulerTypes' => SchedulerType::where('is_active', 1)->get()
        ])->layout('layouts.app',[
            'title' => 'lead enrties & reminders'
        ]);
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

    public function deleteAllReminders($leadId)
    {
        if (Auth::user()->cannot('massDelete', Scheduler::class)) {
            abort(403);
        }

        DB::beginTransaction();

        try {

            DB::table('schedulers')->where('lead_id', $leadId)->delete();

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_MASS_DELETE'),Auth::user()->name.' delete all reminders in lead ID: '.$this->leadId, $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.REMINDERS_DELETED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function deleteAllEntries($leadId)
    {

        if (Auth::user()->cannot('massDelete', LeadEntry::class)) {
            abort(403);
        }

        DB::beginTransaction();

        try {

            DB::table('lead_entries')->where('lead_id', $leadId)->delete();

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_MASS_DELETE'),Auth::user()->name.' delete all entries in lead ID: '.$this->leadId, $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.ENTRIES_DELETED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function deleteReminder($reminderId)
    {
        if (Auth::user()->cannot('delete', Scheduler::find($reminderId))) {
            abort(403);
        }

        DB::beginTransaction();

        try {

            Scheduler::find($reminderId)->delete();

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_DELETE_REMINDER'),Auth::user()->name.' delete a reminder in lead ID: '.$this->leadId, $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.REMINDER_DELTED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function deleteEntry($entryId)
    {
        if (Auth::user()->cannot('delete', LeadEntry::find($entryId))) {
            abort(403);
        }

        DB::beginTransaction();

        try {

            LeadEntry::find($entryId)->delete();

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_DELETE_REMINDER'),Auth::user()->name.' delete a reminder in lead ID: '.$this->leadId, $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.ENTRY_DELETED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
