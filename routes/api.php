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
use App\Http\Controllers\Api\UserProfileController;

Route::as('api.')->group(function () {

    // 1. Landing & Auth Info
    Route::get('/', [LandingController::class, 'index']);
    Route::get('register', [AuthController::class, 'registerInfo']);
    Route::get('login', [AuthController::class, 'loginInfo']);

    // 2. RUTE KHUSUS ARTWORKS (Manajemen Karya)
    Route::get('artworks/karya', [ArtworkController::class, 'index']);
    Route::get('artworks/karya/create', [ArtworkController::class, 'create']);
    Route::get('artworks/karya/{id}', [ArtworkController::class, 'show']);

    // 3. CRUD API LENGKAP
    Route::apiResource('artworks', ArtworkController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('contests', ContestController::class);

    // 4. Dashboard & Galeri
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('galeri/terpilih', [GalleryController::class, 'index']);
    Route::get('galeri/terpilih/{id}', [GalleryController::class, 'show']);

    // 5. RUTE USER PROFILE
    Route::get('profile/{id}', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('me', [UserProfileController::class, 'me'])->name('profile.me');

    // 6. Admin API
    Route::prefix('admin')->group(function () {
        // Rute Moderasi
        Route::get('moderation', [AdminController::class, 'moderationList']);
        Route::get('moderation/{id}', [AdminController::class, 'showModeration']);
        Route::post('moderation/{id}/approve', [AdminController::class, 'approveArtwork']);

        // CRUD Admin (Biasanya admin punya rute resource terpisah jika butuh logika berbeda)
        // Jika sama dengan publik, rute di atas (nomor 3) sebenarnya sudah cukup.
    });
}); // <--- Pastikan kurung penutup group ini ada