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
        Schema::table('users', function (Blueprint $table) {
            // Perluas kolom role menjadi 20 karakter untuk keamanan (cukup untuk 'administrator' atau 'peserta')
            $table->string('role', 20)->default('user')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback ke panjang default sebelumnya (asumsi 10 atau 5)
            // Ganti 10 dengan panjang kolom sebelumnya jika Anda tahu
            $table->string('role', 10)->default('user')->change();
        });
    }
};