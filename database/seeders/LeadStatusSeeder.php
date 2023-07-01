<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lead_statuses')->truncate();
        
        DB::table('lead_statuses')->insert([
            ['name' => 'new lead'],
            ['name' => 'opened'],
            ['name' => 'no answer'],
            ['name' => 'contacted'],
            ['name' => 'contact in future'],
            ['name' => 'following up'],
            ['name' => 'sent email'],
            ['name' => 'sent whatsapp'],
            ['name' => 'site visit'],
            ['name' => 'setup meeting'],
            ['name' => 'call back'],
            ['name' => 'meeting done'],
            ['name' => 'duplicate'],
            ['name' => 'do not call'],
            ['name' => 'not interested'],
            ['name' => 'not qualified'],
            ['name' => 'deal closed'],
            ['name' => 'junk lead'],
            ['name' => 'reshuffle'],
            ['name' => 'site visit done'],
            ['name' => 'follow up after meeting'],
            ['name' => 'switch off'],
            ['name' => 'retain'],
        ]);
    }
}
