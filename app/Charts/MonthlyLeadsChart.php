<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonthlyLeadsChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        $dates = [];
        $leadsCount = [];

        if(Auth::user()->user_type == config('custom.USER_ADMIN')){
            
            $leadStat = DB::table('leads')
                ->select('created_at',DB::raw('count(*) as leadCount'), DB::raw('MONTH(created_at) as month'))
                ->where('created_by', Auth::user()->id)
                ->orderByDesc('created_at')
                ->groupBy('month')
                ->limit(20)
                ->get();

        } else if(Auth::user()->user_type == config('custom.USER_NORMAL')) {

            $leadStat = DB::table('leads')
                ->select(DB::raw('count(*) as leadCount'), DB::raw('MONTH(created_at) as month'))
                ->where(function($query) {
                    $query->where('created_by', Auth::user()->id)
                            ->orWhere('assign_to', Auth::user()->id);
                    })
                ->orderByDesc('created_at')
                ->groupBy('month')
                ->limit(20)
                ->get();

        } else {

            $leadStat = [];
        }

             foreach($leadStat as $ls){
                $dates[] = $monthName = date('F', mktime(0, 0, 0, $ls->month, 10));;
                $leadsCount[] = $ls->leadCount;
             }

        return $this->chart->areaChart()
            ->setColors(['#06A77D', '#ff6384'])
            ->addData('Monthly Leads', array_reverse($leadsCount))
            ->setXAxis(array_reverse($dates))
            ->setColors(['#06A77D', '#303F9F'])
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setGrid();
    }
}
