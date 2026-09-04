<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $month=[3,6,12];
        $rand_keys_month = array_rand($month, 1);
        return [

            'billiards'=>'billiards_6',
            'billiard_id'=>6,
            'summa'=>random_int(1000, 9990),
            'isBar'=>random_int(0, 1),
            'month'=>$month[$rand_keys_month],
            'paid'=>random_int(0, 1),
            'user_id'=>random_int(1, 6),
            'rate_id'=>random_int(1, 8),

        ];
    }
}
