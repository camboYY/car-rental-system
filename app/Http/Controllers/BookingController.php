<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;


class BookingController extends Controller
{

     private $image_url = "https://stimg.cardekho.com/images/carexteriorimages/630x420/Jaguar/F-Pace/10644/1755774688332/front-left-side-47.jpg?tr=w-664";

    // Show booking creation form
    public function create(Request $request)
    {
        $carId = $request->query('car');
        $car = Car::findOrFail($carId);

        return Inertia::render('Bookings/Create', [
            'car' => $car
        ]);
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
        ]);

        $car = Car::findOrFail($data['car_id']);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'car_id' => $car->id,
            'pickup_location' => $data['pickup_location'],
            'status' => 'BOOKED',
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'total_price' => $this->calculateTotalPrice($car, $request),
            "payment_status" => "PENDING"
        ]);

        $car->update(['is_available' => false]);

        return redirect()->route('bookings.show', $booking->id)->with('success', 'Car booked successfully!');
    }

    // Show booking details
    public function show(Booking $booking)
    {
        $booking = Booking::with('car', 'user')
            ->where('user_id', Auth::id())
            ->findOrFail($booking->id);

        return Inertia::render('Bookings/Show', [
            'booking' => [
                'id' => $booking->id,
                'carName' => $booking->car->brand . ' ' . $booking->car->model,
                'plate' => $booking->car->plate_number,
                'image' => $booking->car->image_url ?? $this->image_url,
                'pickupLocation' => $booking->pickup_location,
                'startDate' => $booking->start_date->format('d M Y'),
                'endDate' => $booking->end_date->format('d M Y'),
                'total' => $booking->total_price,
                'status' => $booking->status,
                'paymentStatus' => $booking->payment_status ?? 'Pending',
                'invoiceUrl' => route('bookings.invoice', $booking->id),
            ],
        ]);
    }

   public function myBookings()
    {
        
        $bookings = Booking::with('car')
            ->where('user_id', Auth::id())
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'carName' => $booking->car->brand . ' ' . $booking->car->model,
                    'image' => $booking->car->image_url ?? $this->image_url,
                    'plate' => $booking->car->plate_number,
                    'startDate' => $booking->start_date->format('d M Y'),
                    'endDate' => $booking->end_date->format('d M Y'),
                    'total' => $booking->total_price,
                    'pickupLocation' => $booking->pickup_location ?? 'Phnom Penh Airport',
                    'status' => now()->lt($booking->start_date)
                        ? 'BOOKED'
                        : (now()->between($booking->start_date, $booking->end_date)
                            ? 'ONGOING'
                            : 'RETURNED'),
                    'paymentStatus' => $booking->payment_status,
                    'invoice_url' => route('bookings.invoice', $booking->id),
                ];
            });

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    public function invoice($id)
    {
        $writer = new Writer(
            new ImageRenderer(
                new RendererStyle(100), // size
                new SvgImageBackEnd()
            )
        );


        $booking = Booking::with('car', 'user')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $qrCodeSvg = $writer->writeString(route( 'bookings.show', $booking->id));
        $qrCodeBase64 = 'data:image/png;base64,' . base64_encode($qrCodeSvg);


        $booking = [
                'id' => $booking->id,
                'car'=>  $booking->car->brand . ' ' . $booking->car->model,
                'plate' => $booking->car->plate_number,
                'customer' => $booking->user->name,
                'pickup_location' => $booking->pickup_location,
                'start_date' => $booking->start_date->format('d M Y'),
                'end_date' => $booking->end_date->format('d M Y'),
                'total_price' => $booking->total_price,
                'payment_status' => $booking->payment_status,
                'total_days' => Carbon::parse($booking->start_date)->diffInDays(Carbon::parse($booking->end_date)),
                'price_per_day' => $booking->car->price_per_day,
                "payment_method" => "Cash on Pickup",
                "status" => $booking->status,
                "paid_at" => $booking->paid_at,
                "invoice_number" => $booking->invoice_number
            ];

        $pdf = \PDF::loadView('bookings.invoice', [
            'booking'   => $booking, 
            'qr'        => $qrCodeBase64
            ]);

        return $pdf->download('invoice-'.$booking['id'].'.pdf');
    }

    public function markPaid(Booking $booking)
    {
        abort_if($booking->payment_status === 'PAID', 403);

        $booking->markAsPaid("CASH", "Case on Pickup");

        return back()->with('success', 'Payment received (Cash on Pickup)');
    }

    
    private function calculateTotalPrice(Car $car, Request $request)
    {
        $totalDaysAndDuration = $this->calculateTotalDaysAndDuration($request->start_date, $request->end_date);

        $duration = $totalDaysAndDuration['duration'];
        $durationType = $totalDaysAndDuration['durationType'];
        
        switch ($durationType) {
            case 'daily':
                $total = $car->price_daily * $duration;
                break;

            case 'weekly':
                $total = $car->price_weekly * $duration;
                break;

            case 'monthly':
                $total = $car->price_monthly * $duration;
                break;
        }

        return $total;
    }

    private function calculateTotalDaysAndDuration($start_date, $end_date)
    {
        $days = Carbon::parse($start_date)->diffInDays(Carbon::parse($end_date)) + 1;

        if ($days >= 30) {
            $durationType = 'monthly';
            $duration = ceil($days / 30);

        } elseif ($days >= 7) {
            $durationType = 'weekly';
            $duration = ceil($days / 7);

        } else {
            $durationType = 'daily';
            $duration = $days;
        } 

        return [
            'durationType' => $durationType,
            'duration' => $duration,
        ];
    }
}
