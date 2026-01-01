<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /** ---------------------------
         * Dashboard statistics
         * ---------------------------- */
        $stats = [
            'active' => Booking::where('user_id', $user->id)
                ->where('status', 'ONGOING')
                ->count(),

            'spent' => Booking::where('user_id', $user->id)
                ->where('payment_status', 'PAID')
                ->sum('total_price'),

            'pending' => Booking::where('user_id', $user->id)
                ->where('payment_status', 'PENDING')
                ->count(),
        ];

        /** ---------------------------
         * Active booking (if any)
         * ---------------------------- */
        $activeBooking = Booking::with('car')
            ->where('user_id', $user->id)
            ->where('status', 'ONGOING')
            ->latest()
            ->first();

        /** ---------------------------
         * Recent bookings
         * ---------------------------- */
        $recentBookings = Booking::with('car')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,

            'activeBooking' => $activeBooking
                ? $this->mapBooking($activeBooking)
                : null,

            'recentBookings' => $recentBookings->map(
                fn ($booking) => $this->mapBooking($booking)
            ),
        ]);
    }

    /**
     * Normalize booking data for Vue/TypeScript
     */
    private function mapBooking(Booking $booking): array
    {
        return [
            'id' => $booking->id,
            'carName' => $booking->car->brand . ' ' . $booking->car->model,
            'plate' => $booking->car->plate_number,
            'startDate' => $booking->start_date->format('Y-m-d'),
            'endDate' => $booking->end_date->format('Y-m-d'),
            'total' => $booking->total_price,
            'paymentStatus' => $booking->payment_status,
            'status' => $booking->status,
        ];
    }
}
