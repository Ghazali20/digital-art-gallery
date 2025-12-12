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
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            // Kunci Asing ke tabel users (User yang mengupload)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Kunci Asing ke tabel categories (opsional)
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');

            // Kunci Asing ke tabel contests (opsional, jika ikut kontes)
            $table->foreignId('contest_id')->nullable()->constrained()->onDelete('set null');

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path'); // Path file gambar di storage
            $table->boolean('is_approved')->default(false); // Moderasi oleh Admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};