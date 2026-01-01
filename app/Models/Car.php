<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'plate_number',
        'price_per_day',
        'is_available',
        "image_url",
        "description",
        "category_id",
        'price_daily',
        'price_weekly',
        'price_monthly',
    ];

    /**
     * Get all of the car's bookings.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(CarImage::class)->where('is_primary', true);
    }

}