<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Booking::with('car')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(fn ($booking) => [
                'id' => $booking->id,
                'car' => $booking->car->brand . ' ' . $booking->car->model,
                'plate' => $booking->car->plate_number,
                'total_price' => $booking->total_price,
                'payment_status' => $booking->payment_status,
                'payment_method' => $booking->payment_method,
                'paid_at' => optional($booking->paid_at)?->format('d M Y'),
            ]);

        return Inertia::render('Payments/Index', [
            'payments' => $payments,
        ]);
    }
}
