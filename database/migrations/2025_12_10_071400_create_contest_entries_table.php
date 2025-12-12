// database/migrations/2025_12_10_071400_create_contest_entries_table.php

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contest_entries', function (Blueprint $table) {
            $table->id();

            // Kunci Asing ke Contests (sudah dibuat)
            $table->foreignId('contest_id')->constrained()->onDelete('cascade');

            // Kunci Asing ke Artworks (sudah dibuat)
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');

            $table->unique(['contest_id', 'artwork_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contest_entries');
    }
};