<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Alat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Demo',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Sample Alat Data
        $alats = [
            [
                'nama_alat' => 'Proyektor Epson',
                'deskripsi' => 'Proyektor multimedia untuk presentasi',
                'kategori' => 'Elektronik',
                'stok' => 5,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'Kamera DSLR Canon',
                'deskripsi' => 'Kamera DSLR untuk dokumentasi event',
                'kategori' => 'Fotografi',
                'stok' => 3,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'Sound System Portable',
                'deskripsi' => 'Sistem audio portable dengan microphone',
                'kategori' => 'Audio',
                'stok' => 2,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'Laptop Dell Inspiron',
                'deskripsi' => 'Laptop untuk kebutuhan kerja mobile',
                'kategori' => 'Komputer',
                'stok' => 10,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'Tripod Kamera',
                'deskripsi' => 'Tripod stabil untuk kamera dan smartphone',
                'kategori' => 'Aksesoris',
                'stok' => 8,
                'status' => 'tersedia',
            ],
        ];

        foreach ($alats as $alat) {
            Alat::create($alat);
        }
    }
}
