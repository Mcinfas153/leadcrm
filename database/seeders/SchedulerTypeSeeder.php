<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchedulerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('scheduler_types')->insert([
            ['name' => 'mail', 'is_active' => 1],
            ['name' => 'sms', 'is_active' => 0],
            ['name' => 'notification', 'is_active' => 0]
        ]);
    }
}
