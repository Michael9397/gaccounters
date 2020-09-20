<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            ['name' => 'Owner', 'email' => 'owner@example.com', 'role' => 'owner', 'password' => Hash::make('password')],
            ['name' => 'Admin', 'email' => 'admin@example.com', 'role' => 'admin', 'password' => Hash::make('password')],
            ['name' => 'Free', 'email' => 'free@example.com', 'role' => 'free', 'password' => Hash::make('password')],
            ['name' => 'Customer', 'email' => 'customer@example.com', 'role' => 'customer', 'password' => Hash::make('password')],
            ['name' => 'Normal', 'email' => 'normal@example.com', 'role' => 'normal', 'password' => Hash::make('password')],
        ]);
    }
}
