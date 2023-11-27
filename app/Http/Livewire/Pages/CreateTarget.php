<?php

namespace App\Http\Livewire\Pages;

use App\Models\Target;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CreateTarget extends Component
{

    public $agents;
    public $startingDate;
    public $endingDate;
    public $totalAmount;
    public $achievedAmount;

    protected $rules = [
        'startingDate' => 'required',
        'endingDate' => 'required',
        'totalAmount' => 'required',
        'agents' => 'required',
    ];

    protected $messages = [
        'startingDate.required' => 'The starting date cannot be empty',
        'endingDate.required' => 'The ending date cannot be empty',
        'totalAmount.required' => 'The total amount cannot be empty',
        'agents.required' => 'select at least 1 agent',
    ];

    protected $listeners = [
        'setEndDate', 'setStartDate', 'setAgents'
    ];

    public function render()
    {
        return view('livewire.pages.create-target',[
            'agentList' => User::where(['business_id' => Auth::user()->business_id, 'is_active' => 1, 'user_role' => config('custom.USER_AGENT_ROLE')])->get()
        ])->layout('layouts.app', [
            'title' => 'set target'
        ]);
    }

    public function setStartDate(string $value)
    {
        $this->startingDate = $value;
    }

    public function setEndDate(string $value)
    {
        $this->endingDate = $value;
    }

    public function setAgents(array $value)
    {
        $this->agents = $value;
    }

    public function setTarget()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            
            foreach($this->agents as $agent){

                $target = Target::create([
                    'user_id' => $agent,
                    'starting_date' => $this->startingDate,
                    'ending_date' => $this->endingDate,
                    'total_amount' => $this->totalAmount,
                    'achieved_amount' => ($this->achievedAmount == '' || !isset($this->achievedAmount))? 0: $this->achievedAmount,
                    'business_id' => Auth::user()->business_id,
                    'created_by' => Auth::user()->id
                ]);
            }

            DB::commit();

            return redirect('/agent-targets')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.TARGET_ADDED_SUCCESS')
            ]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            dd($e->getMessage());

        }
    }
}
