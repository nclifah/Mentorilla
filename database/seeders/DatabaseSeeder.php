<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;
use App\Models\Mentor;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Categories
        $categories = [
            ['name' => 'Matematika', 'type' => 'academic', 'description' => 'Kursus matematika untuk semua tingkat'],
            ['name' => 'Bahasa Inggris', 'type' => 'academic', 'description' => 'Kursus bahasa Inggris dan TOEFL'],
            ['name' => 'Fisika', 'type' => 'academic', 'description' => 'Kursus fisika dan sains'],
            ['name' => 'Kimia', 'type' => 'academic', 'description' => 'Kursus kimia untuk SMA dan Kuliah'],
            ['name' => 'Programming', 'type' => 'talent', 'description' => 'Belajar coding: Python, JavaScript, PHP'],
            ['name' => 'Musik', 'type' => 'talent', 'description' => 'Les musik: gitar, piano, drum'],
            ['name' => 'Menggambar', 'type' => 'talent', 'description' => 'Kursus menggambar dan melukis'],
            ['name' => 'Desain Grafis', 'type' => 'talent', 'description' => 'Belajar Photoshop, Illustrator, Figma'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Test Student User
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'user',
        ]);

        // Create Mentor Users & Profiles
        $mentor1 = User::create([
            'name' => 'Dr. Ahmad Wijaya',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'role' => 'mentor',
        ]);

        Mentor::create([
            'user_id' => $mentor1->id,
            'category_id' => 1, // Matematika
            'specialization' => 'Kalkulus, Aljabar Linear, Matematika Diskrit',
            'bio' => 'Dosen matematika dengan pengalaman mengajar 10 tahun di universitas terkemuka. Spesialis dalam kalkulus, aljabar linear, dan matematika diskrit. Sudah membantu ratusan mahasiswa lulus dengan nilai A.',
            'experience_years' => 10,
            'hourly_rate' => 150000,
            'education' => 'S3 Matematika Institut Teknologi Bandung (ITB)',
            'status' => 'available',
            'rating' => 4.8,
            'total_students' => 45,
        ]);

        $mentor2 = User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'role' => 'mentor',
        ]);

        Mentor::create([
            'user_id' => $mentor2->id,
            'category_id' => 2, // Bahasa Inggris
            'specialization' => 'TOEFL, IELTS, Business English',
            'bio' => 'English teacher dengan sertifikasi TESOL internasional. Berpengalaman dalam persiapan TOEFL dan IELTS dengan track record 90% siswa mencapai target score. Metode pengajaran interaktif dan fun!',
            'experience_years' => 7,
            'hourly_rate' => 120000,
            'education' => 'S2 English Literature, University of Melbourne',
            'status' => 'available',
            'rating' => 4.9,
            'total_students' => 62,
        ]);

        $mentor3 = User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567893',
            'role' => 'mentor',
        ]);

        Mentor::create([
            'user_id' => $mentor3->id,
            'category_id' => 5, // Programming
            'specialization' => 'Web Development (Laravel, React, Vue)',
            'bio' => 'Full-stack developer dengan 8 tahun pengalaman di industri tech startup. Expert dalam Laravel, React, dan Vue.js. Sudah membimbing 50+ junior developer menjadi professional.',
            'experience_years' => 8,
            'hourly_rate' => 200000,
            'education' => 'S1 Teknik Informatika Universitas Indonesia',
            'status' => 'available',
            'rating' => 4.7,
            'total_students' => 38,
        ]);

        $mentor4 = User::create([
            'name' => 'Maya Kusuma',
            'email' => 'maya@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567894',
            'role' => 'mentor',
        ]);

        Mentor::create([
            'user_id' => $mentor4->id,
            'category_id' => 6, // Musik
            'specialization' => 'Piano, Keyboard, Music Theory',
            'bio' => 'Pianis profesional dan guru musik bersertifikat. Telah tampil di berbagai konser nasional dan internasional. Mengajar dengan metode yang menyenangkan untuk semua usia, dari pemula hingga advanced.',
            'experience_years' => 12,
            'hourly_rate' => 180000,
            'education' => 'S1 Musik, Berklee College of Music',
            'status' => 'available',
            'rating' => 5.0,
            'total_students' => 71,
        ]);
    }
}
