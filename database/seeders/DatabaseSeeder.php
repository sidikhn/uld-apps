<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <-- Tambahkan baris ini

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@mail.ugm.ac.id'],
            [
                'name'     => 'Admin UGM',
                'role'     => 'admin',
                'password' => Hash::make(env('DEFAULT_ADMIN_PASSWORD', 'admin')),
            ]
        );

        User::firstOrCreate(
            ['email' => 'uld@mail.ugm.ac.id'],
            [
                'name'     => 'ULD',
                'role'     => 'superadmin',
                'password' => Hash::make(env('DEFAULT_SUPERADMIN_PASSWORD', 'password123')),
            ]
        );

        $this->call([
            FacultyStudyProgramSeeder::class,
            MahasiswaSeeder::class, // <-- Tambahkan baris ini
        ]);
    }
}