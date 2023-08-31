<?php

namespace App\Charts;

use App\Models\Target;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class AgentPerfomanceChart
{

    public function __construct(protected LarapexChart $chart){}

    public function build(int $agentId, string $startDate, string $endDate): \ArielMejiaDev\LarapexCharts\PieChart
    {

        $target = Target::where('user_id', $agentId)
                    ->where('starting_date', '>=', $startDate)
                    ->where('ending_date', '<=', $endDate)
                    ->first();

        $user = User::find($agentId);

        $agentName = empty($user) ? "" : $user->name;

        if(empty($target)) {

            $data = [];
            $totalAmount = 0;
            $tagetAchieved = 0;
            
        } else {

            $data = [($target->total_amount - $target->achieved_amount), $target->achieved_amount];
            $totalAmount = $target->total_amount;
            $tagetAchieved = $target->achieved_amount;
        }

        return $this->chart->pieChart()
            ->setTitle($agentName.' - Total Target: ' . number_format($totalAmount, 2).' / Achieved Target: '.number_format($tagetAchieved, 2))
            ->setSubtitle('Target Period: '.$startDate.' - '.$endDate)
            ->addData($data)
            ->setLabels(['Yet to Acheived', 'Acheived']);
    }
}
