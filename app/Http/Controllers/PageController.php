<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;

class PageController extends Controller
{
    /**
     * Menampilkan Galeri Karya Terpilih (mengambil data dari DB).
     */
    public function selectedGallery()
    {
        // Mengambil 4 karya teratas yang sudah di-approve
        $selectedArtworks = Artwork::where('is_approved', true)
                                   ->with('user')
                                   // DIHAPUS: ->withCount('likers')
                                   // DIHAPUS: ->orderByDesc('likers_count')
                                   ->latest() // Mengurutkan berdasarkan waktu pembuatan (default)
                                   ->take(4)
                                   ->get();

        return view('gallery.terpilih', compact('selectedArtworks'));
    }

    /**
     * Menampilkan Panduan Kompetisi statis.
     */
    public function contestGuide()
    {
        return view('contests.panduan');
    }
}