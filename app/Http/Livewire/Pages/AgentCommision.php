<?php

namespace App\Http\Livewire\Pages;

use App\Charts\AgentPerfomanceChart;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AgentCommision extends Component
{

    public int $agentId;
    public string $startDate;
    public string $endDate;
    public $randerChart;

    public function mount()
    {
        $this->agentId = 0;
        $this->startDate = Carbon::now()->subDays(45)->toDateString();
        $this->endDate = Carbon::now()->addDays(45)->toDateString();
    }

    protected $listeners = [
        'setStartDate' => 'setStartDate',
        'setEndDate' => 'setEndDate'
    ];

    public function render(AgentPerfomanceChart $chart)
    {
        return view('livewire.pages.agent-commision',[
            'users' => User::where(['is_active' => 1, 'business_id' => Auth::user()->business_id, 'user_type' => config('custom.USER_NORMAL')])->get(),
            'chart' => $chart->build([], 0, 0, $this->startDate, $this->endDate,'')
        ])->layout('layouts.app', [
            'title' => 'agent commisions'
        ]);
    }

    public function setStartDate($value)
    {
        $this->startDate = $value;
    }

    public function setEndDate($value)
    {
        $this->endDate = $value;
    }

    public function updatedAgentId($value)
    {
       $this->agentId = $value;
    }

}
