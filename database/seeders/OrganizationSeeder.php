<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organizations')->truncate();

        DB::table('organizations')->insert([
            ['name' => 'lead media production','auth_code' => Str::random(16), 'created_by' => 2]
        ]);
    }
}
