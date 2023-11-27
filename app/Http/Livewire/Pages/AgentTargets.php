<?php

namespace App\Http\Livewire\Pages;

use App\Models\Target;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AgentTargets extends Component
{
    use WithPagination;
 
    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['deleteTarget', 'changeTargetStatus'];

    public function render()
    {
        return view('livewire.pages.agent-targets', [
            'targets' => Target::where('business_id', Auth::user()->business_id)
                            ->orderByDesc('created_at')
                            ->paginate(10)
        ])->layout('layouts.app', [
            'title' => 'agent targets'
        ]);
    }

    public function deleteTarget(int $targetId):void
    {
        DB::beginTransaction();

        try {
            
            $target = Target::find($targetId);
            $target->delete();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.TARGET_DELETED_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function changeTargetStatus(int $targetId, int $currentStatus):void
    {
        DB::beginTransaction();

        try {
            
            $target = Target::find($targetId);
            $target->is_active = !$currentStatus;
            $target->save();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.TARGET_UPDATED_SUCCESS')]);

          } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
