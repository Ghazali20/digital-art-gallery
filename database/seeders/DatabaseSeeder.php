<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder kustom Anda
        $this->call([
            // 1. User: Pastikan Admin dan User Dasar ada
            AdminUserSeeder::class, // (Asumsi ini membuat admin@example.com)

            // 2. Data Utama Aplikasi: Kontes, Kategori, dll.
            ContestSeeder::class, // Untuk membuat data kontes dummy
            // CategorySeeder::class, // Panggil seeder Kategori jika ada
        ]);

        // (Opsional) Jika Anda ingin membuat user tambahan di sini
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com', // User standar untuk testing voting/submission
            'role' => 'user',
        ]);

        // (Opsional) User dummy untuk testing
        // User::factory(10)->create();
    }
}