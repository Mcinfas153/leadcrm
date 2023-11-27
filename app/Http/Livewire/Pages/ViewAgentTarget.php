<?php

namespace App\Http\Livewire\Pages;

use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ViewAgentTarget extends Component
{

    public $targetId;
    public $startingDate;
    public $endingDate;
    public $totalAmount;
    public $achievedAmount;
    public $agentName;

    protected $rules = [
        'startingDate' => 'required',
        'endingDate' => 'required',
        'totalAmount' => 'required',
    ];

    protected $messages = [
        'startingDate.required' => 'The starting date cannot be empty',
        'endingDate.required' => 'The ending date cannot be empty',
        'totalAmount.required' => 'The total amount cannot be empty',
    ];

    protected $listeners = [
        'setEndDate', 'setStartDate'
    ];

    public function mount(int $id)
    {
        $this->targetId = $id;
        $target = Target::find($this->targetId);
        $this->startingDate = $target->starting_date;
        $this->endingDate = $target->ending_date;
        $this->totalAmount = $target->total_amount;
        $this->achievedAmount = $target->achieved_amount;
        $this->agentName = $target->agent->name;
    }

    public function render()
    {
        return view('livewire.pages.view-agent-target')->layout('layouts.app', [
            'title' => 'view agent target'
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

    public function updateTarget()
    {
        $this->validate();

        DB::beginTransaction();

        try {
            
            Target::where('id', $this->targetId)
                    ->update([
                        'starting_date' => $this->startingDate,
                        'ending_date' => $this->endingDate,
                        'total_amount' => $this->totalAmount,
                        'achieved_amount' => ($this->achievedAmount == '' || !isset($this->achievedAmount)) ? 0 : $this->achievedAmount
                    ]);

            DB::commit();

            return redirect('/agent-targets')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.TARGET_UPDATED_SUCCESS')
            ]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

            dd($e->getMessage());
        }
    }
}
