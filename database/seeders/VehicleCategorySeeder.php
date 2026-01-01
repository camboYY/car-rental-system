<?php

namespace Database\Seeders;

use App\Models\VehicleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       VehicleCategory::insert([
            ['name' => 'SUV', 'slug' => 'suv'],
            ['name' => 'Sedan', 'slug' => 'sedan'],
            ['name' => 'Van', 'slug' => 'van'],
            ['name' => 'Luxury', 'slug' => 'luxury'],
        ]);

    }
}
