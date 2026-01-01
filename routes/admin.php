<?php 

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehicleCategoryController;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'can:manage-bookings'])->prefix('admin')->group(function () {
    Route::get('/bookings/pickups', [BookingController::class, 'pickups'])
        ->name('admin.bookings.pickups');

    Route::post('/bookings/{booking}/pickup', [BookingController::class, 'confirmPickup'])
        ->name('admin.bookings.pickup');

    Route::get('/bookings/returns', [BookingController::class, 'returns'])
    ->name('admin.bookings.returns');

    Route::post('/bookings/{booking}/return', [BookingController::class, 'confirmReturn'])
        ->name('admin.bookings.return');

    Route::get('/bookings/{booking}/verify', function (Booking $booking) {
        return response()->json([
            'booking_id' => $booking->id,
            'status' => $booking->status,
            'payment' => $booking->payment_status,
        ]);
    })->name('admin.bookings.verify');


    Route::get('/bookings/{booking}/receipt', [BookingController::class, 'receipt'])
        ->name('admin.bookings.receipt');
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::patch('users/{user}/toggle', [UserController::class, 'toggle'])
            ->name('users.toggle');
    });

    Route::middleware(['role:admin,staff'])
    ->name('admin.')
    ->group(function () {
        Route::resource('cars', CarController::class)->except('show');
        Route::patch('cars/{car}/toggle', [CarController::class, 'toggle'])
            ->name('cars.toggle');
    
        Route::resource('categories', VehicleCategoryController::class)
            ->except('show');

        Route::patch('categories/{category}/toggle', [VehicleCategoryController::class, 'toggle'])
            ->name('categories.toggle');

        Route::post('cars/{car}/images', [CarController::class, 'uploadImage'])
            ->name('cars.images.upload');

        Route::delete('cars/images/{image}', [CarController::class, 'deleteImage'])
            ->name('cars.images.delete');

        Route::get('cars/{car}/images', [CarController::class, 'images'])
            ->name('cars.images');

        Route::get('cars/{car}/edit', [CarController::class, 'edit'])
            ->name('cars.edit');

    });


});