<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class BookingController extends Controller
{

    public function ongoing()
    {
        $bookings = Booking::with('car', 'user')
            ->where('status', 'ONGOING')
            ->orderBy('end_date')
            ->paginate(10);

        return Inertia::render('Admin/Bookings/Ongoing', [
            'bookings' => $bookings,
        ]);
    }
    public function pickups()
    {
        $bookings = Booking::with('car', 'user')
            ->where('status', 'BOOKED')
            ->orderBy('start_date')
            ->paginate(10);

        return Inertia::render('Admin/Bookings/Pickups', [
            'bookings' => $bookings,
        ]);
    }

    public function confirmPickup(Booking $booking)
    {
        $booking->update([
            'status' => 'ONGOING',
            'payment_status' => 'PAID',
            'payment_method' => 'CASH',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Pickup confirmed');
    }

    public function returns()
    {
        $bookings = Booking::with('car', 'user')
            ->where('status', 'RETURNED')
            ->orderBy('end_date')
            ->get()
            ->map(fn ($b) => [
                'id' => $b->id,
                'customer' => $b->user->name,
                'car' => $b->car->brand . ' ' . $b->car->model,
                'plate' => $b->car->plate_number,
                'pickup_location' => $b->pickup_location,
                'end_date' => $b->end_date->format('d M Y'),
                'payment_status' => $b->payment_status,
            ]);

        return Inertia::render('Admin/Bookings/Return', [
            'bookings' => $bookings
        ]);
    }

    public function confirmReturn(Booking $booking)
    {
        abort_if($booking->status !== 'ONGOING', 403);

        $booking->update([
            'status' => 'RETURNED'
        ]);

        return back()->with('success', 'Car returned successfully');
    }


    public function receipt(Booking $booking)
    {
        $url = URL::signedRoute('admin.bookings.verify', $booking->id);

        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $qrSvg = $writer->writeString($url);

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
            ],
            'qr' => $qrSvg,
        ]);
    }



}
