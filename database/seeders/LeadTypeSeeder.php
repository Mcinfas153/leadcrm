<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lead_types')->truncate();
        
        DB::table('lead_types')->insert([
            ['name' => 'fresh'],
            ['name' => 'hot'],
            ['name' => 'cold']
        ]);
    }
}
