<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReceiptController extends Controller
{
   public function receipt(Booking $booking)
    {
        return Inertia::render('Admin/Bookings/Receipt', [
            'booking' => [
                'id' => $booking->id,
                'customer' => $booking->user->name,
                'car' => $booking->car->brand . ' ' . $booking->car->model,
                'plate' => $booking->car->plate_number,
                'pickup_location' => $booking->pickup_location,
                'start_date' => $booking->start_date->format('d M Y'),
                'end_date' => $booking->end_date->format('d M Y'),
                'total_price' => $booking->total_price,
                'payment_status' => $booking->payment_status,
            ]
        ]);
    }

}
