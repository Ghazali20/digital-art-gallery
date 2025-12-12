<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            // User yang memberikan like
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Karya yang di-like
            $table->foreignId('artwork_id')->constrained()->onDelete('cascade');

            // Memastikan satu user hanya bisa me-like satu karya sekali
            $table->unique(['user_id', 'artwork_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};