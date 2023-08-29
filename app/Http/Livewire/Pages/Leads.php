<?php

namespace App\Http\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Leads extends Component
{

    public $leadId;
    public $statusId;
    
    protected $listeners = ['leadIdSelect' => 'leadIdSelect'];

    public function mount()
    {
        
    }

    public function render()
    {
        return view('livewire.pages.leads',[
            'lead_status' => DB::table('lead_statuses')->where('is_active', 1)->get()
        ])->layout('layouts.app',[
            'title' => 'all leads'
        ]);
    }

    public function leadIdSelect($leadId)
    {
        $this->leadId = $leadId;
        //$this->dispatchBrowserEvent('tableReload');
        //dd($this->leadId);
    }

    public function changeLeadStatus()
    {
        //dd($this->leadId, $this->statusId);
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

            return redirect()->route('all.leads.page')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.LEAD_STATUS_CHANGE_SUCCESS') 
            ]);;

            //$this->dispatchBrowserEvent('tableReload');

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }

    }
}
