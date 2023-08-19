<?php

namespace App\Http\Livewire\Pages;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FreshLeads extends Component
{

    public $search = '';

    public function render()
    {
        if(Auth::user()->user_type == config('custom.USER_SUPERADMIN')){

            $leads = [];

        } elseif(Auth::user()->user_type == config('custom.USER_ADMIN')){

            $leads = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('leads.created_at')
                        ->where('leads.created_by', Auth::user()->id)
                        ->where('leads.type', '!=', config('custom.LEAD_TYPE_COLD'))                                              
                        ->get();

        } else{

            $leads = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('leads.assign_time')
                        ->where('leads.type', '!=', config('custom.LEAD_TYPE_COLD'))
                        ->where(function($query) {
                            $query->where('leads.assign_to', Auth::user()->id)
                                ->orWhere('leads.created_by', Auth::user()->id);
                        })
                        ->get();
                        
        }

        return view('livewire.pages.fresh-leads',[
            'leads' => $leads
        ])->layout('layouts.app',[
            'title' => 'fresh recent leads'
        ]);
    }
}
