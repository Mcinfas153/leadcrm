<?php

namespace App\Http\Livewire\Pages;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AllLeads extends Component
{

    public $leadId;
    public $statusId;
    public $userId;
    public $bulkAssignUserId;
    public $selectedLeads = [];

    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['leadIdSelect' => 'leadIdSelect', 'leadAgentIdSelect' => 'leadAgentIdSelect', 'bulkDelete' => 'bulkDelete'];

    public function render()
    {
        if(Auth::user()->user_type == config('custom.USER_SUPERADMIN')){

            $leads = DB::table('leads')
                    ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                    ->join('users', 'leads.assign_to', '=', 'users.id')
                    ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                    ->where('leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                    ->orderByDesc('leads.created_at')->paginate(5);

        } elseif(Auth::user()->user_type == config('custom.USER_ADMIN')){

            $leads = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('leads.created_at')
                        ->where('leads.created_by', Auth::user()->id)
                        ->where('leads.type', '!=', config('custom.LEAD_TYPE_COLD'))                        
                        ->paginate(5);

        } else{

            $leads = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('leads.created_at')
                        ->where('leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                        ->where('leads.assign_to', Auth::user()->id)
                        ->orWhere('leads.created_by', Auth::user()->id)
                        ->paginate(5);
                        
        }

        return view('livewire.pages.all-leads',[
            'lead_status' => DB::table('lead_statuses')->where('is_active', 1)->get(),
            'users' => DB::table('users')->where(['business_id' => Auth::user()->business_id, 'is_active' => 1])->get(),
            'leads' =>  $leads,
        ])->layout('layouts.app',[
            'title' => 'all leads'
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

            DB::table('leads')
              ->where('id', $this->leadId)
              ->update(['status' => $this->statusId]);

            DB::commit();

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
              ->update(['assign_to' => $this->userId]);

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.USER_ASSIGN_CHANGE_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }

    }

    public function bulkAssign()
    {

        $this->dispatchBrowserEvent('modalClose');

        DB::beginTransaction();

        try {

            foreach($this->selectedLeads as $leadId){
                DB::table('leads')
                    ->where('id', $leadId)
                    ->update(['assign_to' => $this->bulkAssignUserId]);
            }

            DB::commit();

            $this->selectedLeads = [];

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LAED_MASS_ASSIGN_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

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

                } else{

                    $currentLead->assign_to = Auth::user()->created_by;
                }
            }

            DB::commit();

            $this->selectedLeads = [];

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.LAED_MASS_DELETE_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }

    }
}
