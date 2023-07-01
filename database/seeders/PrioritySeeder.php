<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('priorities')->truncate();

        DB::table('priorities')->insert([
            ['name' => 'normal'],
            ['name' => 'urgent'],
            ['name' => 'very urgent'],
            ['name' => 'top priority']
        ]);
    }
}
