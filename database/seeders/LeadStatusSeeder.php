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
            ['name' => 'new lead', 'color_code' => '#2E86C1'],
            ['name' => 'opened', 'color_code' => '#2471A3'],
            ['name' => 'no answer', 'color_code' => '#EC7063'],
            ['name' => 'contacted', 'color_code' => '#58D68D'],
            ['name' => 'interested', 'color_code' => '#27AE60'],
            ['name' => 'contact in future', 'color_code' => '#2ECC71'],
            ['name' => 'following up', 'color_code' => '#F4D03F'],
            ['name' => 'sent email', 'color_code' => '#F1C40F'],
            ['name' => 'sent whatsapp', 'color_code' => '#D4AC0D'],
            ['name' => 'site visit', 'color_code' => '#28B463'],
            ['name' => 'setup meeting', 'color_code' => '#28B463'],
            ['name' => 'call back', 'color_code' => '#F4D03F'],
            ['name' => 'meeting done', 'color_code' => '#1D8348'],
            ['name' => 'duplicate', 'color_code' => '#DC7633'],
            ['name' => 'do not call', 'color_code' => '#E74C3C'],
            ['name' => 'not interested', 'color_code' => '#E74C3C'],
            ['name' => 'not qualified', 'color_code' => '#E74C3C'],
            ['name' => 'deal closed', 'color_code' => '#186A3B'],
            ['name' => 'junk lead', 'color_code' => '#CB4335 '],
            ['name' => 'reshuffle', 'color_code' => '#5DADE2'],
            ['name' => 'site visit done', 'color_code' => '#239B56'],
            ['name' => 'follow up after meeting', 'color_code' => '#239B56'],
            ['name' => 'switch off', 'color_code' => '#E74C3C'],
            ['name' => 'retain', 'color_code' => '#2E86C1'],
        ]);
    }
}
