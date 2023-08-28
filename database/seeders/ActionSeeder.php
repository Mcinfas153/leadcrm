<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->truncate();
        
        DB::table('actions')->insert([
            ['name' => 'login'],
            ['name' => 'logout'],
            ['name' => 'open lead'],
            ['name' => 'edit lead'],
            ['name' => 'create lead'],
            ['name' => 'delete lead'],
            ['name' => 'make call'],
            ['name' => 'sent email'],
            ['name' => 'sent whatsapp'],
            ['name' => 'change status'],
            ['name' => 'assign user'],
            ['name' => 'schedule callback'],
            ['name' => 'add note'],
            ['name' => 'delete note'],
            ['name' => 'add user'],
            ['name' => 'modify user'],
            ['name' => 'delete user'],
            ['name' => 'change password'],
            ['name' => 'create reminder'],
            ['name' => 'add entry'],
            ['name' => 'delete entry'],
            ['name' => 'delete reminder'],
            ['name' => 'mass delete'],
        ]);
    }
}
