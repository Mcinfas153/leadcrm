<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('report_periods')->insert([
            ['name' => 'daily', 'period' => 'daily'],
            ['name' => 'weekly', 'period' => 'weekly'],
            ['name' => 'monthly', 'period' => 'monthly'],
        ]);
    }
}
