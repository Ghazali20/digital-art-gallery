<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artwork;

class PageController extends Controller
{
    /**
     * Menampilkan Galeri Karya Terpilih (mengambil data dari DB).
     * Diperbarui untuk hanya menampilkan karya yang dikurasi oleh Admin.
     */
    public function selectedGallery()
    {
        // Mengambil karya yang sudah di-approve DAN ditandai sebagai pilihan (is_selected)
        $selectedArtworks = Artwork::where('is_approved', true)
                                   ->where('is_selected', true) // Filter hanya karya hasil kurasi admin
                                   ->with(['user', 'category'])
                                   ->latest()
                                   ->get(); // Mengambil semua karya terpilih tanpa batasan take(4) agar galeri lebih lengkap

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