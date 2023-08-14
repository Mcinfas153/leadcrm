<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReshufflePeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reshuffle_periods')->insert([
            ['name' => '1 hour', 'period' => 1],
            ['name' => '2 hour', 'period' => 2],
            ['name' => '3 hour', 'period' => 3],
            ['name' => '6 hour', 'period' => 6],
            ['name' => '12 hour', 'period' => 12],
            ['name' => '1 day', 'period' => 24],
            ['name' => '2 days', 'period' => 48],
            ['name' => '3 days', 'period' => 72],
        ]);
    }
}
