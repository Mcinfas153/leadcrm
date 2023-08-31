<?php

namespace App\Http\Controllers;

use App\Charts\AgentPerfomanceChart;
use App\Exports\UserReportExport;
use App\Models\Target;
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

        $charts = [];

        $validated = $request->validate([
            'agentId' => 'required|integer',
            'startDate' => 'required',
            'endDate' => 'required',
        ]);

        $user = User::find($request->input('agentId'));
        $agentName = empty($user) ? "" : $user->name;

        $target = Target::where('user_id', $request->input('agentId'))
                    ->where('starting_date', '>=', $request->input('startDate'))
                    ->where('ending_date', '<=', $request->input('endDate'))
                    ->get();

        if(empty($target)) {

            $data = [];
            $totalAmount = 0;
            $tagetAchieved = 0;
            
            $charts[] = $chart->build($data, $totalAmount, $tagetAchieved, $request->input('startDate'), $request->input('endDate'), $agentName);

        } else {

            foreach($target as $t) {

                $data = [($t->total_amount - $t->achieved_amount), $t->achieved_amount];
                $totalAmount = $t->total_amount;
                $tagetAchieved = $t->achieved_amount;

                $charts[] = $chart->build($data, $totalAmount, $tagetAchieved, $t->starting_date, $t->ending_date, $agentName);
            }
        }

        return view('agent-performance', [
            'charts' => $charts,
            'title' => $user->name. ' performance report'
        ]);
    }
}
