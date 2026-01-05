<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat user Admin pertama
        User::create([
            'name' => 'Admin Galeri Utama',
            'email' => 'admin@galeri.com',
            'password' => Hash::make('password'),
            'role' => 'admin', //
        ]);

        // (Opsional) Membuat user biasa untuk testing
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@galeri.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}