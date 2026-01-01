<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->decimal('price_daily', 10, 2)->default(0);
            $table->decimal('price_weekly', 10, 2)->nullable();
            $table->decimal('price_monthly', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['price_daily', 'price_weekly', 'price_monthly']);
        });
    }
};
