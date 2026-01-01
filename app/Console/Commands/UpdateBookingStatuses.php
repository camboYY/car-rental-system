<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class UpdateBookingStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-booking-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update booking statuses based on start and end dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Booking::where('status', 'BOOKED')
            ->whereDate('start_date', '<=', now())
            ->update(['status' => 'ONGOING']);

        Booking::where('status', 'ONGOING')
            ->whereDate('end_date', '<', now())
            ->update(['status' => 'RETURNED']);

        $this->info('Booking statuses updated successfully.');

    }
}
