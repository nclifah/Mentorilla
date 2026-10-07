<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    
    public function up(): void
    {
        Schema::create('mentors', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel users (siapa orangnya)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Menghubungkan ke tabel categories (bidang apa: akademik/talent)
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->uuid('uuid')->unique(); // ID unik untuk keamanan URL
            $table->string('specialization'); // Keahlian khusus (misal: Fisika Nuklir)
            $table->text('bio'); // Profil singkat
            $table->integer('experience_years'); // Berapa tahun pengalaman
            $table->decimal('hourly_rate', 10, 2); // Harga per jam
            $table->string('education'); // Pendidikan terakhir
            $table->string('photo')->nullable(); // Foto profil

            $table->enum('status', ['available', 'busy', 'inactive'])->default('available');
            $table->decimal('rating', 3, 2)->default(0); // Rating (0.00 - 5.00)
            $table->integer('total_students')->default(0);

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('mentors');
    }
};
