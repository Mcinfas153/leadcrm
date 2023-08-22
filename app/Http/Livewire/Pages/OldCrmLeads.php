<?php

namespace App\Http\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use App\Http\Traits\ActivityTrait;
use App\Mail\BulkLeadsAssign;
use App\Mail\LeadAssign;
use App\Models\LeadType;
use App\Models\Note;
use App\Models\OldCrmLead;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OldCrmLeads extends Component
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

            $leads = DB::table('leads')
                    ->join('lead_statuses', 'old_crm_leads.status', '=', 'lead_statuses.id')
                    ->join('users', 'old_crm_leads.assign_to', '=', 'users.id')
                    ->select('old_crm_leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                    ->where('old_crm_leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                    ->orderByDesc('old_crm_leads.created_at')->paginate(5);

        } elseif(Auth::user()->user_type == config('custom.USER_ADMIN')){

            $leads = DB::table('old_crm_leads')
                        ->join('lead_statuses', 'old_crm_leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'old_crm_leads.assign_to', '=', 'users.id')
                        ->select('old_crm_leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('old_crm_leads.created_at')
                        ->where('old_crm_leads.created_by', Auth::user()->id)
                        ->where('old_crm_leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                        ->where(function($query) {
                            $query->where('old_crm_leads.fullname', 'like', '%'.$this->search.'%')
                                ->orWhere('old_crm_leads.phone', 'like', '%'.$this->search.'%')
                                ->orWhere('old_crm_leads.email', 'like', '%'.$this->search.'%')
                                ->orWhere('old_crm_leads.campaign_name', 'like', '%'.$this->search.'%');
                        })->when($this->filterUserId, function ($query, $filterUserId) {
                            $query->where('old_crm_leads.assign_to', $filterUserId);
                        })->when($this->filterStatusID, function ($query, $filterStatusID) {
                            $query->where('old_crm_leads.status', $filterStatusID);
                        })                                               
                        ->paginate(5);

        } else{

            $leads = DB::table('old_crm_leads')
                        ->join('lead_statuses', 'old_crm_leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'old_crm_leads.assign_to', '=', 'users.id')
                        ->select('old_crm_leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('old_crm_leads.assign_time')
                        ->where('old_crm_leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                        ->where(function($query) {
                            $query->where('old_crm_leads.assign_to', Auth::user()->id)
                                ->orWhere('old_crm_leads.created_by', Auth::user()->id);
                        })
                        ->where(function($query) {
                            $query->where('old_crm_leads.fullname', 'like', '%'.$this->search.'%')
                                ->orWhere('old_crm_leads.phone', 'like', '%'.$this->search.'%')
                                ->orWhere('old_crm_leads.email', 'like', '%'.$this->search.'%')
                                ->orWhere('old_crm_leads.campaign_name', 'like', '%'.$this->search.'%');
                        })->when($this->filterStatusID, function ($query, $filterStatusID) {
                            $query->where('old_crm_leads.status', $filterStatusID);
                        })
                        ->paginate(5);
                        
        }

        return view('livewire.pages.old-crm-leads',[
            'lead_status' => DB::table('lead_statuses')->where('is_active', 1)->get(),
            'users' => DB::table('users')->where(['business_id' => Auth::user()->business_id, 'is_active' => 1])->get(),
            'leads' =>  $leads,
            'leadTypes' => LeadType::all()
        ])->layout('layouts.app',[
            'title' => 'old crm leads'
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

        DB::beginTransaction();

        try {

            DB::table('old_crm_leads')
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

            DB::table('old_crm_leads')
              ->where('id', $this->leadId)
              ->update(['assign_to' => $this->userId, 'assign_time' => Carbon::now()]);

            DB::commit();

            ActivityTrait::add(Auth::user()->id, config('custom.ACTION_ASSIGN_USER'),Auth::user()->name.' assign the lead', $this->leadId);

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.USER_ASSIGN_CHANGE_SUCCESS')]);

            //notify agent
            if(config('custom.IS_MAIL_ON')){
                Mail::to(User::find($this->userId)->email)->queue(new LeadAssign(OldCrmLead::find($this->leadId)));
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
                DB::table('old_crm_leads')
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

                $currentLead = OldCrmLead::find($leadId);

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

        $lead = OldCrmLead::find($leadId);

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
