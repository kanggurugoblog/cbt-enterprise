<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Kategori Ujian
        $categories = [
            ['name' => 'Penilaian Harian', 'code' => 'PH'],
            ['name' => 'Sumatif Tengah Semester 1', 'code' => 'STS1'],
            ['name' => 'Sumatif Akhir Semester 1', 'code' => 'SAS1'],
            ['name' => 'Sumatif Tengah Semester 2', 'code' => 'STS2'],
            ['name' => 'Sumatif Akhir Semester 2', 'code' => 'SAS2'],
            ['name' => 'Penilaian Sumatif Akhir Jenjang', 'code' => 'PSAJ'],
            ['name' => 'Try Out Ujian', 'code' => 'TO'],
        ];
        DB::table('exam_categories')->insert($categories);

        // 2. Seed Mata Pelajaran Dasar
        $subjects = [
            ['name' => 'Matematika', 'code' => 'MTK'],
            ['name' => 'Bahasa Indonesia', 'code' => 'BIN'],
            ['name' => 'Bahasa Inggris', 'code' => 'BIG'],
            ['name' => 'Pendidikan Agama Islam', 'code' => 'PAI'],
        ];
        DB::table('subjects')->insert($subjects);

        // 3. Seed Tingkat (Grades)
        $gradeIds = [];
        foreach ([10, 11, 12] as $g) {
            $gradeIds[$g] = DB::table('grades')->insertGetId(['name' => (string)$g]);
        }

        // 4. Seed Jurusan (Majors)
        $majors = [
            ['name' => 'Teknik Komputer dan Jaringan', 'code' => 'TKJ'],
            ['name' => 'Teknik Sepeda Motor', 'code' => 'TSM'],
            ['name' => 'Desain Pemodelan dan Informasi Bangunan', 'code' => 'DPB'], // Diubah dari DPB agar sinkron
        ];
        $majorIds = [];
        foreach ($majors as $m) {
            $majorIds[$m['code']] = DB::table('majors')->insertGetId($m);
        }

        // 5. Seed Kelas (Classrooms) & Generate Siswa
        // Loop untuk membuat kelas 10, 11, 12 untuk TKJ, TSM, DPB
        foreach ([10, 11, 12] as $g) {
            foreach (['TKJ', 'TSM', 'DPB'] as $mCode) {
                // Buat 2 rombel per jurusan (Contoh: 10 TKJ 1, 10 TKJ 2)
                foreach ([1, 2] as $rombel) {
                    $classroomId = DB::table('classrooms')->insertGetId([
                        'name' => "{$g} {$mCode} {$rombel}",
                        'grade_id' => $gradeIds[$g],
                        'major_id' => $majorIds[$mCode]
                    ]);

                    // Generate 5 siswa acak menggunakan Factory untuk SETIAP kelas (Total 3 tingkat x 3 jurusan x 2 rombel x 5 siswa = 90 Siswa)
                    User::factory()->count(5)->create()->each(function ($user) use ($classroomId) {
                        DB::table('classroom_user')->insert([
                            'user_id' => $user->id,
                            'classroom_id' => $classroomId,
                            'academic_year' => '2025/2026',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    });
                }
            }
        }

        // 6. Seed Akun Guru & Pengawas Mandiri untuk Login Uji Coba
        User::create([
            'name' => 'Bapak Guru CBT',
            'username' => 'guru123',
            'email' => 'guru@cbt.com',
            'role' => 'guru',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Ibu Pengawas Ruang',
            'username' => 'pengawas123',
            'email' => 'pengawas@cbt.com',
            'role' => 'pengawas',
            'password' => Hash::make('password'),
        ]);
    }
}
