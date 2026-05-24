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
        // 1. Tambahkan kolom role ke tabel users bawaan Laravel
        Schema::table('users', function (Blueprint $table) {
            // Kolom role: admin, guru, pengawas, siswa
            $table->string('role')->default('siswa')->after('email');
            $table->string('username')->nullable()->unique()->after('id'); // Untuk login siswa pakai NISN/No Ujian
        });

        // 2. Buat tabel pivot untuk menghubungkan Siswa ke Kelas
        Schema::create('classroom_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained('classrooms')->onDelete('cascade');
            $table->string('academic_year'); // Contoh: 2025/2026
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classroom_user');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'username']);
        });
    }
};
