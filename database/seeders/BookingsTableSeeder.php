<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = [
            [
                'user_id' => 1,
                'car_id' => 1,
                'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
            ],
            [
                'user_id' => 2,
                'car_id' => 2,
                'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
            ],
            [
                'user_id' => 1,
                'car_id' => 3,
                'start_date' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(4)->format('Y-m-d'),
            ],
            [
                'user_id' => 3,
                'car_id' => 4,
                'start_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(12)->format('Y-m-d'),
            ],
        ];

        foreach ($bookings as $booking) {
            // Calculate total price based on car price_per_day
            $carPrice = DB::table('cars')->where('id', $booking['car_id'])->value('price_per_day');
            $days = Carbon::parse($booking['start_date'])->diffInDays(Carbon::parse($booking['end_date']));
            $totalPrice = $carPrice * $days;

            DB::table('bookings')->insert([
                'user_id' => $booking['user_id'],
                'car_id' => $booking['car_id'],
                'start_date' => $booking['start_date'],
                'end_date' => $booking['end_date'],
                'total_price' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
