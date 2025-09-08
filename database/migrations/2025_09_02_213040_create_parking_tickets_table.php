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
        Schema::create('parking_tickets', function (Blueprint $table) {
            $table->id();

            // Gate Masuk & Keluar
            $table->unsignedBigInteger('gate_in_id');
            $table->unsignedBigInteger('gate_out_id')->nullable();
            $table->foreign('gate_in_id')->references('id')->on('parking_gates')->onDelete('cascade');
            $table->foreign('gate_out_id')->references('id')->on('parking_gates')->onDelete('set null');

            // Informasi Tiket
            $table->string('ticket_number')->unique();
            $table->dateTime('exited_at')->nullable(); // waktu keluar
            $table->integer('duration_minutes')->nullable(); // durasi parkir, hitung dari issued_at ke exited_at

            $table->string('vehicle_plate_number');
            $table->foreignId('vehicle_type_id')->nullable()->constrained()->nullOnDelete()->index();
            $table->enum('status', ['active', 'expired', 'paid'])->default('active');

            // Detail Transaksi dan Pembayaran
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->string('currency', 3)->default('IDR');
            $table->string('payment_method')->nullable(); // misal: cash, qris
            $table->string('transaction_id')->nullable()->unique();
            $table->string('external_reference')->nullable()->unique();
            $table->dateTime('paid_at')->nullable();
            $table->foreignId('paid_by')->nullable()->constrained('users')->nullOnDelete();

            // Penerbit & Pembatalan
            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('cancelled_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();

            // Informasi Tambahan
            $table->string('name')->nullable(); // bisa dihapus jika tidak digunakan
            $table->string('description')->nullable();
            $table->string('notes')->nullable();
            $table->string('slug')->unique()->nullable(); // bisa dihapus jika tidak digunakan

            // Status Eksternal
            $table->string('status_message')->nullable();
            $table->string('status_code')->nullable();

            // Metadata
            $table->json('metadata')->nullable(); // ganti dari string ke json untuk fleksibilitas

            // Audit Trail
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            // Jejak Pengguna
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            //Dokumentasi
            $table->string('photo_in')->nullable(); // Foto masuk
            $table->string('photo_out')->nullable(); // Foto keluar

            // Waktu
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_tickets');
    }
};
