<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\MailMessage;
use Faker\Factory as Faker;
use Carbon\Carbon;
class MailMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $statuses = ['pending', 'sent', 'failed'];

        $data = [];
        for ($i = 0; $i < 120; $i++) {
            $createdAt = Carbon::now()->subDays(rand(0, 365))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $updatedAt = (rand(0, 1) === 1) ? $createdAt->copy()->addDays(rand(0, 30)) : $createdAt; // Sometimes updated later, sometimes same as created

            $data[] = [
                'name'       => $faker->name,
                'email'      => $faker->unique()->safeEmail,
                'message'    => $faker->sentence(10),
                'status'     => $statuses[array_rand($statuses)],
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
            ];
        }

        MailMessage::insert($data);
    }
}
