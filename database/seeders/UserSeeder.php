<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();

        DB::table('users')->insert([
            ['name' => 'lead media production',
            'email' => 'superadmin@leadmediaproduction.com',
            'password' => Hash::make('1234'),
            'user_type' => config('custom.USER_SUPERADMIN'),
            'user_role' => 1,
            'created_by' => 0],
            ['name' => 'admin one',
            'email' => 'admin@leadmediaproduction.com',
            'password' => Hash::make('1234'),
            'user_type' => config('custom.USER_ADMIN'),
            'user_role' => 2,
            'created_by' => 1],
            ['name' => 'agnet one',
            'email' => 'agentone@leadmediaproduction.com',
            'password' => Hash::make('1234'),
            'user_type' => config('custom.USER_NORMAL'),
            'user_role' => 3,
            'created_by' => 2],
            ['name' => 'agent two',
            'email' => 'agenttwo@leadmediaproduction.com',
            'password' => Hash::make('1234'),
            'user_type' => config('custom.USER_NORMAL'),
            'user_role' => 3,
            'created_by' => 2]
        ]);
    }
}
