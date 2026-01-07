<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        return Inertia::render('Admin/Dashboard', [
            'todayPickups' => Booking::with('car', 'user')
                ->whereDate('start_date', $today)
                ->where('status', 'ONGOING')
                ->count(),

            'todayReturns' => Booking::with('car', 'user')
                ->whereDate('end_date', $today)
                ->where('status', 'RETURNED')
                ->count(),

            'todayBookings' => Booking::with('car', 'user')
                ->where('status', 'BOOKED')
                ->whereDate('start_date', $today)
                ->count(),
        ]);
    }
}
