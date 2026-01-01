<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use PragmaRX\Google2FA\Google2FA;


if (app()->environment('local')) {
    Route::get('/dev/otp/{user}', function (User $user) {
        if (!$user->two_factor_secret) {
            return 'User has no 2FA secret';
        }

        $google2fa = new Google2FA();

        // Decrypt secret
        $secret = decrypt($user->two_factor_secret);

        // Generate current OTP
        $otp = $google2fa->getCurrentOtp($secret);

        return [
            'user' => $user->email,
            'otp' => $otp,
        ];
    });
}


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', [DashboardController::class, "index"])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', fn () => redirect('/cars'));

Route::middleware(['auth'])->group(function () {

    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    })->name('logout');

    Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
    Route::get('/cars/{car}', action: [CarController::class, 'show'])->name('cars.show');

    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store')   ;
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])
        ->name('my-bookings');
    Route::get('/bookings/{id}/invoice', [BookingController::class, 'invoice'])->name('bookings.invoice');
    
    Route::get('/customer/profile', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::put('/customer/profile', [CustomerProfileController::class, 'update'])->name('customer.profile.update');
    Route::put('/customer/profile/password', [CustomerProfileController::class, 'updatePassword'])
        ->name('customer.profile.password.update');
        
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');

    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{booking}', [InvoiceController::class, 'show'])->name('invoices.show');
});





require __DIR__.'/settings.php';
require __DIR__.'/admin.php';

