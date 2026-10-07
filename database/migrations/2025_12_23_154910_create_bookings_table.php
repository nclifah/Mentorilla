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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique(); // ID unik untuk transaksi

            // Relasi: Siapa yang memesan (user_id) dan siapa mentornya (mentor_id)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained()->onDelete('cascade');

            // Detail Waktu
            $table->date('booking_date'); // Tanggal pertemuan
            $table->time('start_time');   // Jam mulai
            $table->time('end_time');     // Jam selesai
            $table->integer('duration_hours'); // Durasi (misal: 2 jam)

            // Detail Pembayaran
            $table->decimal('total_price', 10, 2); // Total biaya
            $table->text('notes')->nullable();     // Catatan tambahan dari siswa

            // Status Transaksi
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
