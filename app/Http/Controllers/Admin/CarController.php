<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;


class CarController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Cars/Index', [
            
            'categories' => VehicleCategory::where('is_active', true)
                ->withCount('cars')
                ->get(),
    
            'cars' => Car::with("category")->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'plate_number' => 'required|unique:cars',
            'price_per_day' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:vehicle_categories,id',
            'price_daily' => 'required|numeric|min:1',
            'price_weekly' => 'nullable|numeric|min:1',
            'price_monthly' => 'nullable|numeric|min:1',
            'status' => 'required|in:available,maintenance,rented',
        ]);

        Car::create([
            ...$request->all()
        ]);

        return back()->with('success', 'Car added successfully');
    }

    public function update(Request $request, Car $car)
    {
        $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'plate_number' => 'required|unique:cars,plate_number,' . $car->id,
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,maintenance,rented',
            'image_url' => 'nullable|url',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:vehicle_categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'price_daily' => 'required|numeric|min:1',
            'price_weekly' => 'nullable|numeric|min:1',
            'price_monthly' => 'nullable|numeric|min:1',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('cars', 'public');

                $car->images()->create([
                    'path' => $path,
                    'is_primary' => $car->images()->count() === 0,
                ]);
            }
        }

        $car->update([...$request->all(),...["image_url" => $path]]);

        return back()->with('success', 'Car updated');
    }

    public function toggle(Request $request, Car $car)
    {
        $car = Car::findOrFail($car->id);
        $car->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Availability updated');
    }

    public function destroy(Car $car)
    {
        $car->delete();

        return back()->with('success', 'Car deleted');
    }

    public function uploadImage(Request $request, Car $car)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('cars', 'public');

        $car->images()->create([
            'path' => $path,
            'is_primary' => $car->images()->count() === 0,
        ]);

        return back()->with('success', 'Image uploaded successfully');
    }

    public function deleteImage(CarImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image removed');
    }


    public function images(Car $car)
    {
        return Inertia::render('Admin/Cars/Images', [
            'carId' => $car->id,
            'images' => $car->images,
        ]);
    }

    public function edit(Car $car)
    {
        return Inertia::render('Admin/Cars/Edit', [
            'car' => $car->load(['images', 'category']),
            'categories' => VehicleCategory::all(),
        ]);
    }


}
