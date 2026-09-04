<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => 'Aleks Majlo',
            'email' => 'aleksmajlo@billiard-city.com',
            'password' => Hash::make('11111111'),
            'phone'=>'+380677855392'
        ]);
        DB::table('users')->insert([
            'name' => 'Александр Степанов',
            'email' => 'Ruks@billiard-city.com',
            'password' => Hash::make('11111111'),
            'phone'=>'+380675440151',
        ]);

    }
}
