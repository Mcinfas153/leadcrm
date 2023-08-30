<?php

namespace App\Http\Livewire\Pages;

use App\Models\Scheduler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Reminders extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'remindersStatusChange' => 'remindersStatusChange',
        'deleteReminder' => 'deleteReminder'
    ];

    public function render()
    {

        if(Auth::user()->user_type == config('custom.USER_ADMIN')){

            $reminders = DB::table('schedulers')
                        ->select('schedulers.*', 'users.name as ownerName','users.business_id', 'scheduler_types.name as schedulerType')
                        ->join('users', 'schedulers.owner', '=', 'users.id')
                        ->join('scheduler_types', 'schedulers.type', '=', 'scheduler_types.id')
                        ->where('users.business_id', Auth::user()->business_id)
                        ->orderByDesc('reminder_time')
                        ->paginate(10);
        } else {

            $reminders = DB::table('schedulers')
                        ->select('schedulers.*', 'users.name as ownerName','users.business_id', 'scheduler_types.name as schedulerType')
                        ->join('users', 'schedulers.owner', '=', 'users.id')
                        ->join('scheduler_types', 'schedulers.type', '=', 'scheduler_types.id')
                        ->where('schedulers.owner', Auth::user()->id)
                        ->orderByDesc('reminder_time')
                        ->paginate(10);

        }

        return view('livewire.pages.reminders',[
            'reminders' => $reminders
        ])->layout('layouts.app',[
            'title' => 'reminders'
        ]);
    }

    public function remindersStatusChange(int $reminderId, int $currentStatus)
    {
       DB::beginTransaction();

       try {
        
            Scheduler::where('id', $reminderId)->update([
                'is_active' => !$currentStatus
            ]);

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.REMINDERS_UPDATED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }

    public function deleteReminder(int $reminderId)
    {
       DB::beginTransaction();

       try {
        
            Scheduler::where('id', $reminderId)->delete();

            DB::commit();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'success', 'title' => config('message.REMINDER_DELTED_SUCCESS')]);

        } catch (\Exception $e) {

            DB::rollBack();

            $this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);

        }
    }
}
