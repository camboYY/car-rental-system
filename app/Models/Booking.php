<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'car_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'pickup_location',
        'payment_status', // optional, e.g., 'PENDING', 'PAID'
        'payment_method',
        'paid_at',
        'invoice_number'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',        
        'paid_at' => 'datetime',

    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Booking belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsPaid(string $method, ?string $reference = null)
    {
        $this->update([
            'payment_status' => 'PAID',
            'payment_method' => $method,
            'payment_reference' => $reference,
            'paid_at' => now(),
        ]);
    }

    public function getTotalDaysAttribute(): int
    {
        return $this->start_date->diffInDays($this->end_date);
    }

}
