<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. AKUN ADMIN (Bisa akses Manajemen Mata Kuliah, CPL, CPMK, dll)
        User::create([
            'name' => 'RANGGA ABIMANYU EFENDI (ADMIN)',
            'email' => 'admin@politani.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        // 2. AKUN KAPRODI (Bisa akses CPL, CPMK, Validasi RPS, dll)
        User::create([
            'name' => 'KAPRODI JURUSAN (KAPRODI)',
            'email' => 'kaprodi@politani.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'kaprodi'
        ]);

        // 3. AKUN DOSEN (Hanya bisa akses CPMK, Pembuatan RPS, Rubrik Penilaian)
        User::create([
            'name' => 'DOSEN PENGAJAR (DOSEN)',
            'email' => 'dosen@politani.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'dosen'
        ]);
    }
}