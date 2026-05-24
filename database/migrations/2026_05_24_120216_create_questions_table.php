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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_bank_id')->constrained('question_banks')->onDelete('cascade');

            $table->longText('question_text'); // Mendukung teks panjang + HTML gambar inline jika ada
            $table->enum('type', ['pilihan_ganda', 'esai'])->default('pilihan_ganda');
            $table->integer('order')->default(1); // Untuk mengurutkan nomor soal

            // Penyimpanan Media Mandiri (Fase 2 Blueprint)
            $table->string('image_path')->nullable();
            $table->string('audio_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
