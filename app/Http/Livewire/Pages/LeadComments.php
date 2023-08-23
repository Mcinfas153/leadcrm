<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Http\Traits\ActivityTrait;

class LeadComments extends Component
{

    use ActivityTrait;

    public $leadId;
    public $note;
    public $limitPerPage = 5;
    public $activityLimitPerPage = 5;

    protected $rules = [
        'note' => 'required'
    ];

    protected $messages = [
        'note.required' => 'The note cannot be empty.',
    ];

    protected $listeners = [
        'load-more' => 'loadMore',
        'deleteNote' => 'deleteNote'
    ];

    public function mount($leadId)
    {
        $this->leadId = $leadId;
    }

    public function loadMore()
    {
        $this->limitPerPage = $this->limitPerPage + 5;
    }

    public function render()
    {

        if (Auth::user()->cannot('view', Lead::find($this->leadId))) {
            abort(403);
        }

        return view('livewire.pages.lead-comments',[
            'notes' => Note::where('lead_id', $this->leadId)
                        ->orderByDesc('created_at')
                        //->get(),
                        ->paginate($this->limitPerPage),
        ])->layout('layouts.app',[
            'title' => 'lead comments & activities'
        ]);
        
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
}
