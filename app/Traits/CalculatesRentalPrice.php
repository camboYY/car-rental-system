<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Car;
use InvalidArgumentException;

trait CalculatesRentalPrice
{
    /**
     * Calculate rental days (inclusive)
     */
    protected function calculateRentalDays(
        string $startDate,
        string $endDate
    ): int {
        return Carbon::parse($startDate)
            ->diffInDays(Carbon::parse($endDate)) + 1;
    }

    /**
     * Calculate total rental price
     */
    protected function calculateRentalPrice(
        Car $car,
        string $priceType,
        int $days
    ): float {
        return match ($priceType) {
            'daily'   => $car->price_per_day * $days,
            'weekly'  => $car->price_weekly * ceil($days / 7),
            'monthly' => $car->price_monthly * ceil($days / 30),

            default => throw new InvalidArgumentException(
                "Invalid price type: {$priceType}"
            ),
        };
    }

    /**
     * Helper: calculate days + price together
     */
    protected function calculateRental(
        Car $car,
        string $startDate,
        string $endDate,
        string $priceType
    ): array {
        $days = $this->calculateRentalDays($startDate, $endDate);

        return [
            'days' => $days,
            'total_price' => $this->calculateRentalPrice(
                $car,
                $priceType,
                $days
            ),
        ];
    }
}
