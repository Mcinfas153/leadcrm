<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Traits\ActivityTrait;
use App\Mail\BulkLeadsAssign;
use App\Mail\LeadAssign;
use App\Models\LeadType;
use App\Models\Note;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class DumpLeadsPage extends Component
{

    use WithPagination;
    use ActivityTrait;

    public $leadId;
    public $statusId;
    public $userId;
    public $bulkAssignUserId;
    public $selectedLeads = [];
    public $search = '';
    public $filterUserId;
    public $filterStatusID;
 
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'leadIdSelect' => 'leadIdSelect', 
        'leadAgentIdSelect' => 'leadAgentIdSelect',
        'bulkDelete' => 'bulkDelete',
        'deleteLead' => 'deleteLead',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if(Auth::user()->user_type == config('custom.USER_SUPERADMIN')){

            $leads = [];

        } elseif(Auth::user()->user_type == config('custom.USER_ADMIN')){

            $leads = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('leads.created_at')
                        ->where('leads.created_by', Auth::user()->id)
                        ->where('leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                        ->whereIn('leads.status', [config('custom.LEAD_STATUS_NOT_INTERESTED'),config('custom.LEAD_STATUS_NOT_QUALIFIED'),config('custom.LEAD_STATUS_JUNK_LEAD')])
                        ->where(function($query) {
                            $query->where('leads.fullname', 'like', '%'.$this->search.'%')
                                ->orWhere('leads.phone', 'like', '%'.$this->search.'%')
                                ->orWhere('leads.email', 'like', '%'.$this->search.'%')
                                ->orWhere('leads.campaign_name', 'like', '%'.$this->search.'%');
                        })->when($this->filterUserId, function ($query, $filterUserId) {
                            $query->where('assign_to', $filterUserId);
                        })->when($this->filterStatusID, function ($query, $filterStatusID) {
                            $query->where('status', $filterStatusID);
                        })                                               
                        ->paginate(5);

        } else{

            $leads = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('leads.assign_time')
                        ->where('leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                        ->where(function($query) {
                            $query->where('leads.assign_to', Auth::user()->id)
                                ->orWhere('leads.created_by', Auth::user()->id);
                        })
                        ->whereIn('leads.status', [config('custom.LEAD_STATUS_NOT_INTERESTED'),config('custom.LEAD_STATUS_NOT_QUALIFIED'),config('custom.LEAD_STATUS_JUNK_LEAD')])
                        ->where(function($query) {
                            $query->where('leads.fullname', 'like', '%'.$this->search.'%')
                                ->orWhere('leads.phone', 'like', '%'.$this->search.'%')
                                ->orWhere('leads.email', 'like', '%'.$this->search.'%')
                                ->orWhere('leads.campaign_name', 'like', '%'.$this->search.'%');
                        })->when($this->filterStatusID, function ($query, $filterStatusID) {
                            $query->where('status', $filterStatusID);
                        })
                        ->paginate(5);
                        
        }

        return view('livewire.pages.dump-leads-page',[
            'lead_status' => DB::table('lead_statuses')->where('is_active', 1)->get(),
            'users' => DB::table('users')->where(['business_id' => Auth::user()->business_id, 'is_active' => 1])->get(),
            'leads' =>  $leads,
            'leadTypes' => LeadType::all()
        ])->layout('layouts.app',[
            'title' => 'dump leads'
        ]);
    }

    public function leadIdSelect($leadId, $statusId)
    {
        $this->leadId = $leadId;
        $this->statusId = $statusId;
    }

    public function leadAgentIdSelect($leadId, $agentId)
    {
        $this->leadId = $leadId;
        $this->userId = $agentId;
    }

    public function changeLeadStatus()
    {
        $this->dispatchBrowserEvent('modalClose');

        if($this->statusId == config('custom.LEAD_STATUS_DEAL_CLOSED')){
            return redirect('/close-lead/'.$this->leadId);
        }

        DB::beginTransaction();

        try {

            DB::table('leads')
              ->where('id', $this->leadId)
              ->update(['status' => $this->statusId]);

            DB::commit();

            ActivityTrait::add(Auth::user()->id,config('custom.ACTION_CHANGE_STATUS'),Auth::user()->name.' changed the lead status', $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LEAD_STATUS_CHANGE_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }

    }

    public function changeAgent()
    {
        $this->dispatchBrowserEvent('modalClose');

        DB::beginTransaction();

        try {

            DB::table('leads')
              ->where('id', $this->leadId)
              ->update(['assign_to' => $this->userId, 'assign_time' => Carbon::now()]);

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_ASSIGN_USER'),Auth::user()->name.' assign the lead', $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.USER_ASSIGN_CHANGE_SUCCESS')]);

            //notify agent
            if(config('custom.IS_MAIL_ON')){
                Mail::to(User::find($this->userId)->email)->queue(new LeadAssign(Lead::find($this->leadId)));
            }            

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            dd($e->getMessage());

        }

    }

    public function bulkAssign()
    {
        $this->validate(
            ['bulkAssignUserId' => 'required'],
            [
                'bulkAssignUserId.required' => 'The :attribute cannot be empty.',
            ],
            ['bulkAssignUserId' => 'user']
        );

        $this->dispatchBrowserEvent('modalClose');

        DB::beginTransaction();

        try {

            foreach($this->selectedLeads as $leadId){
                DB::table('leads')
                    ->where('id', $leadId)
                    ->update(['assign_to' => $this->bulkAssignUserId, 'assign_time' => Carbon::now()]);
            }

            DB::commit();

            $this->selectedLeads = [];

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_ASSIGN_USER'),Auth::user()->name.' assign bulk leads');

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LAED_MASS_ASSIGN_SUCCESS')]);

            //notify agent
            if(config('custom.IS_MAIL_ON')){
                Mail::to(User::find($this->bulkAssignUserId)->email)->queue(new BulkLeadsAssign);
            }

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            dd($e->getMessage());
        }

    }

    public function bulkDelete()
    {

        DB::beginTransaction();

        try {

            foreach($this->selectedLeads as $leadId){

                $currentLead = Lead::find($leadId);

                if($currentLead->created_by == Auth::user()->id){

                    $currentLead->delete();

                    Note::where('lead_id', $leadId)->delete();

                } else{

                    $currentLead->assign_to = Auth::user()->created_by;
                }
            }

            DB::commit();

            $this->selectedLeads = [];

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_DELETE_LEAD'),Auth::user()->name.' delete bulk leads');

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LAED_MASS_DELETE_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }

    }

    public function deleteLead($leadId)
    {

        $lead = Lead::find($leadId);

        if (Auth::user()->cannot('delete', $lead)) {
            abort(403);
        }

        DB::beginTransaction();

        try {

           $lead->delete();

           Note::where('lead_id', $leadId)->delete();

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_DELETE_LEAD'),Auth::user()->name.' delete the lead', $leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LEAD_DELETED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            //dd($e->getMessage());

        }

    }
}
