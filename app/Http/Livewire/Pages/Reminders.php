<?php

namespace App\Http\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Reminders extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

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
}
