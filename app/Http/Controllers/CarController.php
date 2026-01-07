<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarController extends Controller
{
    public function index()
    {
        return Inertia::render('Cars/Index', [
            'cars' => Car::with("category")->where('status', 'available')->paginate(10)
        ]);
    }

    public function show(Car $car)
    {
        return Inertia::render('Cars/Show', [
            'car' => $car,
            "category"=>$car->category
        ]);
    }

    // Show booking creation form
    public function booking(Car $car)
    {
        $carId = $car->id;
        $car = Car::findOrFail($carId);

        return Inertia::render('Cars/Booking', [
            'car' => $car
        ]);
    }
}
