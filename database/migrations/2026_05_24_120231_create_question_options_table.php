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
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');

            $table->text('option_text'); // Teks pilihan jawaban (A, B, C, D, E)
            $table->boolean('is_correct')->default(false); // Penanda Kunci Jawaban
            $table->string('image_path')->nullable(); // Opsi jawaban bisa berupa gambar

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
};
