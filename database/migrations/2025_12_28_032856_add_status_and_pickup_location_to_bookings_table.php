<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('pickup_location')->nullable()->after('car_id');
            $table->enum('status', [
                'BOOKED',
                'ONGOING',
                'RETURNED',
                'CANCELLED'
            ])->default('BOOKED')->after('total_price');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['pickup_location', 'status']);
        });
    }
};
