<?php

namespace App\Http\Livewire\Pages;

use App\Models\CloseDeal;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CloseDeals extends Component
{

    public $leadId, $totalValue, $totalCommision, $agentId, $agentCommision;

    protected $rules = [
        'totalValue' => 'required',
        'totalCommision' => 'required|lt:totalValue',
        'agentId' => 'required',
        'agentCommision' => 'required|lte:totalCommision',
    ];
 
    protected $messages = [
        'totalValue.required' => 'The total value cannot be empty',
        'totalCommision.required' => 'The total commision cannot be empty',
        'totalCommision.lt:totalValue' => 'The total commision cannot be more than total value',
        'agentId.required' => 'Please select an agent',
        'agentCommision.required' => 'The agent commision cannot be empty',
        'agentCommision.lte:totalCommision' => 'The agent commision cannot be more than total commision',
    ];

    public function mount(int $leadId)
    {
        $this->leadId = $leadId;
    }

    public function render()
    {
        return view('livewire.pages.close-deals',[
            'agents' => User::where(['business_id' => Auth::user()->business_id, 'is_active' => 1, 'user_type' => config('custom.USER_NORMAL')])->get()
        ])->layout('layouts.app',[
            'title' => 'closing deal'
        ]);
    }

    public function closeDeal()
    {

        if (Auth::user()->cannot('isAdmin', User::class)) {
            abort(403);
        }

        $this->validate();

        $commisonDetails = ['user_id' => $this->agentId, 'commision' => $this->agentCommision];

        DB::beginTransaction();

        try {
            
            CloseDeal::create([
                'lead_id' => $this->leadId,
                'total_value' => $this->totalValue,
                'total_commision' => $this->totalCommision,
                'commision_details' => json_encode($commisonDetails),
                'business_id' => Auth::user()->business_id
            ]);

            Lead::where('id', $this->leadId)->update(['status' => config('custom.LEAD_STATUS_DEAL_CLOSED')]);

            DB::commit();

            return redirect('/leads')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.DEAL_CLOSED_SUCCESS')
            ]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            dd($e->getMessage());

        }
    }
}
