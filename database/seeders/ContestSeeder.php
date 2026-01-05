<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contest;

class ContestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contest::create([
            'title' => 'Kompetisi Ilustrasi Fantasi',
            'description' => 'Ajang untuk seniman digital bertema fantasi epik.',
            'start_date' => now()->subDay(), // Mulai kemarin (Sedang Berlangsung)
            'end_date' => now()->addDays(7), // Berakhir 7 hari lagi
            'is_active' => true,
        ]);

        Contest::create([
            'title' => 'Pameran Seni Abstrak',
            'description' => 'Tunjukkan kemampuan Anda dalam seni abstrak modern.',
            'start_date' => now()->addDays(10), // Akan Datang
            'end_date' => now()->addDays(20),
            'is_active' => true,
        ]);

       
        Contest::create([
            'title' => 'Tantangan Desain Poster',
            'description' => 'Buat poster digital paling inovatif.',
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(2),
            'is_active' => true,
        ]);
    }
}