<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Http\Traits\DateTrait;
use App\Http\Traits\LeadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailyLeadsChart
{

    use DateTrait; 

    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {

        $dates = [];
        $leadsCount = [];

        if(Auth::user()->user_type == config('custom.USER_ADMIN')){
            
            $leadStat = DB::table('leads')
                ->select('created_at',DB::raw('count(*) as leadCount'), DB::raw('DATE(created_at) as date'))
                ->where('created_by', Auth::user()->id)
                ->orderByDesc('created_at')
                ->groupBy('date')
                ->limit(20)
                ->get();

        } else if(Auth::user()->user_type == config('custom.USER_NORMAL')) {

            $leadStat = DB::table('leads')
                ->select(DB::raw('count(*) as leadCount'), DB::raw('DATE(created_at) as date'))
                ->where(function($query) {
                    $query->where('created_by', Auth::user()->id)
                            ->orWhere('assign_to', Auth::user()->id);
                    })
                ->orderByDesc('created_at')
                ->groupBy('date')
                ->limit(20)
                ->get();

        } else {

            $leadStat = [];
        }

             foreach($leadStat as $ls){
                $dates[] = $ls->date;
                $leadsCount[] = $ls->leadCount;
             }

        return $this->chart->lineChart()
            ->addData('Daily Leads', array_reverse($leadsCount))
            ->setXAxis(array_reverse($dates));
    }
}
