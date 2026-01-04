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
            // Menambah field untuk profil lengkap
            $table->string('profile_photo')->nullable()->after('email');
            $table->text('bio')->nullable()->after('profile_photo');
            $table->string('instagram_handle')->nullable()->after('bio');
            $table->string('portfolio_link')->nullable()->after('instagram_handle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menghapus field jika rollback
            $table->dropColumn(['profile_photo', 'bio', 'instagram_handle', 'portfolio_link']);
        });
    }
};