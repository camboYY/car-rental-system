<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Camry',
                'plate_number' => '2AA-1234',
                'price_per_day' => 80.00,
                'is_available' => true,
                'image_url' => 'https://source.unsplash.com/400x300/?toyota,camry',
                'description' => 'Comfortable mid-size sedan, perfect for city and highway driving.',
            ],
            [
                'brand' => 'Honda',
                'model' => 'Civic',
                'plate_number' => '2BB-5678',
                'price_per_day' => 70.00,
                'is_available' => true,
                'image_url' => 'https://source.unsplash.com/400x300/?honda,civic',
                'description' => 'Compact sedan with excellent fuel efficiency and modern features.',
            ],
            [
                'brand' => 'Ford',
                'model' => 'Mustang',
                'plate_number' => '2CC-9012',
                'price_per_day' => 150.00,
                'is_available' => false,
                'image_url' => 'https://source.unsplash.com/400x300/?ford,mustang',
                'description' => 'Sporty coupe with powerful engine and iconic design.',
            ],
            [
                'brand' => 'BMW',
                'model' => 'X5',
                'plate_number' => '2DD-3456',
                'price_per_day' => 200.00,
                'is_available' => true,
                'image_url' => 'https://source.unsplash.com/400x300/?bmw,x5',
                'description' => 'Luxury SUV with premium comfort and advanced safety features.',
            ],
            [
                'brand' => 'Tesla',
                'model' => 'Model 3',
                'plate_number' => '2EE-7890',
                'price_per_day' => 180.00,
                'is_available' => true,
                'image_url' => 'https://source.unsplash.com/400x300/?tesla,model3',
                'description' => 'Electric car with autopilot features and cutting-edge technology.',
            ],
        ];

        foreach ($cars as $car) {
            DB::table('cars')->insert(array_merge($car, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
