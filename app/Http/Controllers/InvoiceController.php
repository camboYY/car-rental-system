<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Booking::with('car')
            ->where('user_id', Auth::id())
            ->latest()
            ->get()
            ->map(fn ($b) => [
                'id' => $b->id,
                'invoice_number' => $b->invoice_number,
                'car' => $b->car->brand . ' ' . $b->car->model,
                'total_price' => $b->total_price,
                'payment_status' => $b->payment_status,
                'created_at' => $b->created_at->format('d M Y'),
                'tatal_days' => $b->total_days,
            ]);

        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices,
        ]);
    }

    public function show(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $booking->load('car');

    // Format dates
    $bookingFormatted = [
        'id' => $booking->id,
        'invoice_number' => $booking->invoice_number,
        'car' => $booking->car->brand . ' ' . $booking->car->model,
        'pickup_location' => $booking->pickup_location,
        'start_date' => $booking->start_date->format('d M Y'),
        'end_date' => $booking->end_date->format('d M Y'),
        'total_price' => $booking->total_price,
        'status' => $booking->status,
        'payment_method' => $booking->payment_method,
        'payment_status' => $booking->payment_status,
        'paid_at' => $booking->paid_at?->format('d M Y H:i'),
        'total_days' => $booking->total_days
    ];

        return Inertia::render('Invoices/Show', [
            'booking' => $bookingFormatted
        ]);
    }

    public function download(Booking $booking)
    {
        abort_if($booking->user_id !== Auth::id(), 403);

        $pdf = Pdf::loadView('invoices.pdf', [
            'booking' => $booking->load('car', 'user'),
        ]);

        return $pdf->download('invoice-' . $booking->invoice_number . '.pdf');
    }
}
