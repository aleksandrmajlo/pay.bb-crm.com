<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BilliardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('billiards')->insert([
            'name' => 'Bb Crm',
            'idd' => 'billiards_1',
            'date_end' => '2031-04-16',
            'created_at'=>now()
        ]);
        DB::table('billiards')->insert([
            'name' => 'Tennis Park',
            'idd' => 'billiards_2',
            'date_end' => '2031-04-16',
            'created_at'=>now()
        ]);
        DB::table('billiards')->insert([
            'name' => 'FM312',
            'idd' => 'billiards_3',
            'date_end' => '2031-04-16',
            'created_at'=>now()
        ]);
        DB::table('billiards')->insert([
            'name' => 'Bb Crm 4',
            'idd' => 'billiards_4',
            'date_end' => '2031-04-16',
            'created_at'=>now()
        ]);
        DB::table('billiards')->insert([
            'name' => 'Tennis Club',
            'idd' => 'billiards_5',
            'date_end' => '2031-04-16',
            'created_at'=>now()
        ]);
        DB::table('billiards')->insert([
            'name' => 'Tennis Club',
            'idd' => 'billiards_6',
            'date_end' => '2011-04-16',
            'created_at'=>now()
        ]);
    }
}
