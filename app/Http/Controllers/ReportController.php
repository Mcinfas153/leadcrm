<?php

namespace App\Http\Controllers;

use App\Charts\AgentPerfomanceChart;
use App\Exports\UserReportExport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function userReportExport($userId, $period) 
    {
        $user = User::find($userId);
        return (new UserReportExport)->forUser($userId)->forPeriod($period)->download($user->name.'.xlsx');
    }

    public function agentPerformanceChart(Request $request, AgentPerfomanceChart $chart)
    {

        $validated = $request->validate([
            'agentId' => 'required|integer',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        $user  = User::find($request->input('agentId'));

        return view('agent-performance', [
            'chart' => $chart->build($request->input('agentId'),$request->input('startDate'), $request->input('endDate')),
            'title' => $user->name. ' performance report'
        ]);
    }
}
