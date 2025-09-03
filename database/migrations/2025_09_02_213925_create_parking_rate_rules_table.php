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
        Schema::create('parking_rate_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_type_id')->constrained()->onDelete('cascade')->index();
            $table->integer('start_minute'); // menit awal aturan berlaku
            $table->integer('end_minute')->nullable(); // menit akhir aturan, null = tak terbatas
            $table->decimal('fixed_price', 10, 2)->nullable(); // tarif tetap
            $table->decimal('per_hour_price', 10, 2)->nullable(); // tarif per jam
            $table->decimal('per_day_price', 10, 2)->nullable(); // tarif per hari
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_rate_rules');
    }
};
