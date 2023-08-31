<?php

namespace App\Charts;

use App\Models\Target;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AgentPerfomanceChart
{

    public function __construct(protected LarapexChart $chart){}

    public function build($data, $totalAmount, $tagetAchieved, $startDate, $endDate, $agentName): \ArielMejiaDev\LarapexCharts\PieChart
    {
        return $this->chart->pieChart()
            ->setTitle($agentName.' - Total Target: ' . number_format($totalAmount, 2).' / Achieved Target: '.number_format($tagetAchieved, 2))
            ->setSubtitle('Target Period: '.$startDate.' - '.$endDate)
            ->addData($data)
            ->setLabels(['Yet to Acheived', 'Acheived']);
    }
}
