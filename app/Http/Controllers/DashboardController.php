<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Artwork;
// Tambahkan model dan library yang dibutuhkan untuk statistik
use App\Models\Contest;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Fungsi helper sederhana untuk memformat angka besar ke K+ (misalnya: 12450 -> 12K+)
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

    public function index()
    {
        $user = Auth::user();

        // LOGIKA KARYA (GALERI GLOBAL)
        $globalApprovedArtworks = Artwork::where('is_approved', true)
                                      ->with('user')
                                      // DIHAPUS: ->withCount('likers')
                                      ->latest() // Diurutkan berdasarkan created_at
                                      ->take(8)
                                      ->get();

        // LOGIKA STATISTIK (REAL-TIME)
        $activeContestsCount = Contest::where('is_active', true)
                                      ->where('end_date', '>', Carbon::now())
                                      ->count();

        $totalArtworksCount = Artwork::where('is_approved', true)->count();
        $activeArtistsCount = User::where('role', 'peserta')->count();

        $totalVisitors = 12450;
        $formattedTotalVisitors = $this->formatNumberToK($totalVisitors);


        return view('dashboard', [
            'globalApprovedArtworks' => $globalApprovedArtworks,
            'activeContestsCount' => $activeContestsCount,
            'totalArtworksCount' => $totalArtworksCount,
            'activeArtistsCount' => $activeArtistsCount,
            'formattedTotalVisitors' => $formattedTotalVisitors,
        ]);
    }
}