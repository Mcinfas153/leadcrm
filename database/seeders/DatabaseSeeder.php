<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            LeadSeeder::class,
            ActionSeeder::class,
            LeadStatusSeeder::class,
            LeadTypeSeeder::class,
            OrganizationSeeder::class,
            PrioritySeeder::class,
            UserTypeSeeder::class,
            UserRoleSeeder::class,
            ReportPeriodSeeder::class,
            ReshufflePeriodSeeder::class
        ]);
    }
}
