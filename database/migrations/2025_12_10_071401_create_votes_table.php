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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();

            // Kunci Asing ke tabel users (Siapa yang vote)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Kunci Asing ke tabel contest_entries (Entri Kontes mana yang di-vote)
            $table->foreignId('contest_entry_id')->constrained()->onDelete('cascade');

            // Mencegah User vote entri kontes yang sama lebih dari 1 kali
            $table->unique(['user_id', 'contest_entry_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            // Hapus foreign key sebelum menghapus tabel
            if (Schema::hasColumn('votes', 'user_id')) {
                $table->dropForeign(['user_id']);
            }
            if (Schema::hasColumn('votes', 'contest_entry_id')) {
                $table->dropForeign(['contest_entry_id']);
            }
        });

        Schema::dropIfExists('votes');
    }
};