<?php

namespace App\Http\Controllers;

use App\Exports\ExportLead;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LeadImport;
use App\Imports\OldCrmLeadsImport;

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

        $validated = $request->validate([
            'file' => 'required',
            'leadType' => 'required',
        ]);

        if($request->input('importAssignUserId') == '' || $request->input('importAssignUserId') == null){
            $userAssignId = Auth::user()->id;
        } else {
            $userAssignId = $request->input('importAssignUserId');
        }

        try {

            Excel::import(new LeadImport($userAssignId, $request->input('leadType')), $request->file);


            return redirect()->back()->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.LEAD_IMPORT_SUCCESS'),
            ]);
            
          
          } catch (\Exception $e) {
 
            return back()->with([
                'status' => 'error',
                'icon' => 'error',
                'title' => Str::limit($e->getMessage(), 90) 
            ]);

        }

    }

    public function exportLeads($leadType = null){
        return Excel::download(new ExportLead($leadType), 'leads.xlsx');
    }

    public function importOldCrmLeads(Request $request)
    {

        $validated = $request->validate([
            'file' => 'required',
            'leadType' => 'required',
        ]);

        if($request->input('importAssignUserId') == '' || $request->input('importAssignUserId') == null){
            $userAssignId = Auth::user()->id;
        } else {
            $userAssignId = $request->input('importAssignUserId');
        }

        try {

            Excel::import(new OldCrmLeadsImport($userAssignId, $request->input('leadType')), $request->file);


            return redirect()->back()->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => config('message.LEAD_IMPORT_SUCCESS'),
            ]);
            
          
          } catch (\Exception $e) {
 
            return back()->with([
                'status' => 'error',
                'icon' => 'error',
                'title' => Str::limit($e->getMessage(), 90) 
            ]);

        }

    }

    
}
