<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('langs')->insertOrIgnore([
            [
                'name' => 'English',
                'slug' => 'en',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ukrainian',
                'slug' => 'uk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
