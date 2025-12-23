<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\ArtworkModerationController;
use App\Http\Controllers\Admin\AdminContestController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 0. ROUTE UTAMA / LANDING PAGE
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome_landing');
})->name('landing');

// Dashboard User
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// 1. ROUTE KHUSUS USER (SENIMAN) - CRUD KARYA SENI
Route::middleware(['auth'])->prefix('artworks/karya')->name('artworks.')->group(function () {
    Route::get('/', [ArtworkController::class, 'index'])->name('index'); // Untuk menu "Karya Seni Saya"
    Route::get('/create', [ArtworkController::class, 'create'])->name('create');
    Route::post('/', [ArtworkController::class, 'store'])->name('store');
    Route::get('/{artwork}/edit', [ArtworkController::class, 'edit'])->name('edit');
    Route::put('/{artwork}', [ArtworkController::class, 'update'])->name('update');
    Route::delete('/{artwork}', [ArtworkController::class, 'destroy'])->name('destroy');
});

// 2. ROUTE KHUSUS ADMIN
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('contests', AdminContestController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('moderation', [ArtworkModerationController::class, 'index'])->name('moderation.index');
    Route::put('moderation/{artwork}/approve', [ArtworkModerationController::class, 'approve'])->name('moderation.approve');
    Route::delete('moderation/{artwork}/reject', [ArtworkModerationController::class, 'reject'])->name('moderation.reject');
});

// 3. ROUTE KHUSUS USER (PUBLIC) - KONTES DAN GALERI
Route::get('/galeri/terpilih', [PageController::class, 'selectedGallery'])->name('gallery.terpilih');
Route::get('/kompetisi/panduan', [PageController::class, 'contestGuide'])->name('contests.guide');

// Rute Publik Kontes & Karya (Agar Navigasi Web Normal)
Route::get('artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');
Route::get('contests', [ContestController::class, 'index'])->name('contests.index'); // Untuk menu "Kompetisi Seni"
Route::get('contests/{contest}', [ContestController::class, 'show'])->name('contests.show');

// Autentikasi User
Route::middleware(['auth'])->group(function () {
    Route::get('/become-peserta', [UserController::class, 'createPesertaApplication'])->name('user.peserta.create');
    Route::post('/upgrade-to-peserta', [UserController::class, 'upgradeToPeserta'])->name('user.upgrade');

    Route::get('contests/{contest}/submit', [ContestController::class, 'createEntry'])->name('contests.createEntry');
    Route::post('contests/{contest}/submit', [ContestController::class, 'storeEntry'])->name('contests.storeEntry');
    Route::post('entries/{contestEntry}/vote', [ContestController::class, 'vote'])->name('contests.vote');
});

require __DIR__.'/auth.php';