<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import semua Controller API
use App\Http\Controllers\Api\ArtworkController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContestController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\LandingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
<<<<<<< HEAD
=======
use App\Http\Controllers\Api\UserProfileController;
>>>>>>> 400abec99392b2896bbdb5243495ba58dd6f505d

Route::as('api.')->group(function () {
    // 1. Landing & Auth Info
    Route::get('/', [LandingController::class, 'index']);
    Route::get('register', [AuthController::class, 'registerInfo']);
    Route::get('login', [AuthController::class, 'loginInfo']);

    // 2. RUTE KHUSUS ARTWORKS
    Route::get('artworks/karya', [ArtworkController::class, 'index']);
    Route::get('artworks/karya/create', [ArtworkController::class, 'create']);
    Route::get('artworks/karya/{id}', [ArtworkController::class, 'show']);

    // 3. --- CRUD API LENGKAP (apiResource) ---
    Route::apiResource('artworks', ArtworkController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('contests', ContestController::class);

    // 4. Dashboard & Galeri
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('galeri/terpilih', [GalleryController::class, 'index']);
<<<<<<< HEAD
    Route::get('galeri/terpilih/{id}', [GalleryController::class, 'show']); //

    // 5. Admin API
    Route::prefix('admin')->group(function () {
        // Rute Moderasi
        Route::get('moderation', [AdminController::class, 'moderationList']);
        Route::get('moderation/{id}', [AdminController::class, 'showModeration']); // Perbaikan: Menangani ID agar tidak 404
=======
    Route::get('galeri/terpilih/{id}', [GalleryController::class, 'show']);

    // 5. --- RUTE USER PROFILE (BAGIAN YANG DIPERBAIKI) ---
    // Menambahkan ->name('profile.show') agar bisa dipanggil oleh Blade
    Route::get('profile/{id}', [UserProfileController::class, 'show'])->name('profile.show');

    // Menambahkan ->name('profile.me') sebagai rute profil diri sendiri
    Route::get('me', [UserProfileController::class, 'me'])->name('profile.me');

    // 6. Admin API
    Route::prefix('admin')->group(function () {
        // Rute Moderasi
        Route::get('moderation', [AdminController::class, 'moderationList']);
        Route::get('moderation/{id}', [AdminController::class, 'showModeration']);
>>>>>>> 400abec99392b2896bbdb5243495ba58dd6f505d
        Route::post('moderation/{id}/approve', [AdminController::class, 'approveArtwork']);

        // CRUD Admin untuk Categories dan Contests
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('contests', ContestController::class);
    });
});