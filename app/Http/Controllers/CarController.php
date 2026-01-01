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
            'cars' => Car::where('is_available', true)->get()
        ]);
    }

    public function show(Car $car)
    {
        return Inertia::render('Cars/Show', [
            'car' => $car
        ]);
    }
}
