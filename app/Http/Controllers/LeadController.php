<?php

namespace App\Http\Controllers;

use App\Exports\ExportLead;
use App\Imports\ActionsImport;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadImport;

class LeadController extends Controller
{
    public function getAllLeads(Request $request)
    {
        if ($request->ajax()) {
            
            if(Auth::user()->user_type == config('custom.USER_SUPERADMIN')){
                $data = DB::table('leads')
                        ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                        ->join('users', 'leads.assign_to', '=', 'users.id')
                        ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                        ->orderByDesc('leads.created_at');
            } elseif(Auth::user()->user_type == config('custom.USER_ADMIN')){
                $data = DB::table('leads')
                            ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                            ->join('users', 'leads.assign_to', '=', 'users.id')
                            ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                            ->orderByDesc('leads.created_at')
                            ->where('leads.created_by', Auth::user()->id);
            } else{
                $data = DB::table('leads')
                            ->join('lead_statuses', 'leads.status', '=', 'lead_statuses.id')
                            ->join('users', 'leads.assign_to', '=', 'users.id')
                            ->select('leads.*', 'lead_statuses.name as lead_status','lead_statuses.color_code as color_code','users.name as assign_user')
                            ->orderByDesc('leads.created_at')
                            ->where('leads.assign_to', Auth::user()->id);
            }
            
            return Datatables::of($data)
                    ->editColumn('created_at', '{{getDateFormat($created_at)}}')
                    ->editColumn('lead_status', function($data) {
                        return '<span onclick="changeStatus('.$data->id.')" style="background-color:'.$data->color_code.'" class="badge fw-semibold py-2 px-3 text-white fs-2">' . Str::title($data->lead_status) . '</span>';
                    })
                    //->editColumn('lead_status', '<span style="" class="badge fw-semibold py-2 px-3 text-white fs-2">{{Str::title("$lead_status")}}</span>')
                    ->editColumn('campaign_name', '{{Str::title("$campaign_name")}}')
                    ->editColumn('assign_user', '{{Str::title("$assign_user")}}')
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
       
                            $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
      
                            return $btn;
                    })
                    ->escapeColumns([])
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function importLeads(Request $request)
    {
        try {

            Excel::import(new LeadImport, $request->file);


            return redirect()->back()->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.LEAD_IMPORT_SUCCESS'),
            ]);;
            
          
          } catch (\Exception $e) {

            //$this->dispatchBrowserEvent('pushToast', ['icon' => 'error', 'title' => config('message.SOMETHING_HAPPENED')]);
          
            dd($e->getMessage());

        }

    }

    public function exportLeads(Request $request){
        return Excel::download(new ExportLead, 'users.xlsx');
    }

    
}
