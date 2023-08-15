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
            ['name' => 'daily', 'period' => 1],
            ['name' => 'weekly', 'period' => 2],
            ['name' => 'monthly', 'period' => 3],
        ]);
    }
}
