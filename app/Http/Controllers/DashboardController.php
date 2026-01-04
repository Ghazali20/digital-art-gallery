<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artwork;
use App\Models\Category; // Tambahkan import Category
use App\Models\Contest;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Fungsi helper sederhana untuk memformat angka besar ke K+
    protected function formatNumberToK($n) {
        if ($n > 999) {
            $n = round($n / 1000, 1);
            if (fmod($n, 1.0) == 0.0) {
                return intval($n) . 'K+';
            }
            return $n . 'K+';
        }
        return number_format($n);
    }

    /**
     * Menampilkan Dashboard dengan Galeri Global yang bisa difilter.
     */
    public function index(Request $request) // Tambahkan Request $request
    {
        $user = Auth::user();

        // 1. LOGIKA KARYA (GALERI GLOBAL DENGAN FILTER)
        // Mulai query dengan eager loading user dan category
        $query = Artwork::where('is_approved', true)->with(['user', 'category']);

        // Filter Pencarian: Judul Karya atau Nama Seniman
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($userQuery) use ($request) {
                      $userQuery->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Ambil hasil filter, urutkan yang terbaru
        $globalApprovedArtworks = $query->latest()->get();

        // 2. LOGIKA STATISTIK (REAL-TIME)
        $activeContestsCount = Contest::where('is_active', true)
                                      ->where('end_date', '>', Carbon::now())
                                      ->count();

        $totalArtworksCount = Artwork::where('is_approved', true)->count();
        $activeArtistsCount = User::where('role', 'peserta')->count();

        $totalVisitors = 12450;
        $formattedTotalVisitors = $this->formatNumberToK($totalVisitors);

        // Ambil semua kategori untuk dropdown filter
        $categories = Category::all();

        return view('dashboard', [
            'globalApprovedArtworks' => $globalApprovedArtworks,
            'categories' => $categories, // Kirim variabel categories ke view
            'activeContestsCount' => $activeContestsCount,
            'totalArtworksCount' => $totalArtworksCount,
            'activeArtistsCount' => $activeArtistsCount,
            'formattedTotalVisitors' => $formattedTotalVisitors,
        ]);
    }
}