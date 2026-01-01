<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class VehicleCategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Categories/Index', [
            'categories' => VehicleCategory::latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:vehicle_categories,name',
        ]);

        VehicleCategory::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return back()->with('success', 'Category created');
    }

    public function update(Request $request, VehicleCategory $category)
    {
        $data = $request->validate([
            'name' => 'required|unique:vehicle_categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        return back()->with('success', 'Category updated');
    }

    public function destroy(VehicleCategory $category)
    {
        if ($category->cars()->exists()) {
            return back()->with('error', 'Category has vehicles');
        }

        $category->delete();

        return back()->with('success', 'Category deleted');
    }

    public function toggle(VehicleCategory $category)
    {
        $category->update([
            'is_active' => ! $category->is_active,
        ]);

        return back();
    }
}
