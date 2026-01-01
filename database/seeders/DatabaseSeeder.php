<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

            // Ensure at least one admin
        User::factory()->create([
            'email' => 'admin@demo.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'email' => 'staff@demo.com',
            'role' => 'staff',
        ]);

        $this->call([   
            VehicleCategorySeeder::class,         
            CarsTableSeeder::class,
            BookingsTableSeeder::class,
        ]);

    }
}
