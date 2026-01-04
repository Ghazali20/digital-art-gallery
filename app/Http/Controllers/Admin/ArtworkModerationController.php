<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
// Import Notifikasi
use App\Notifications\ArtworkApprovedNotification;
use App\Notifications\ArtworkRejectedNotification; // Tambahkan import ini

class ArtworkModerationController extends Controller
{
    /**
     * Menampilkan daftar Karya Seni.
     * Diperbarui agar Admin bisa melihat karya yang sudah approve untuk dikurasi.
     */
    public function index()
    {
        $artworks = Artwork::with('user', 'category')
                          ->orderBy('is_approved', 'asc') // Karya pending muncul di atas
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);

        return view('admin.moderation.index', compact('artworks'));
    }

    /**
     * Memproses persetujuan (approval) Karya Seni dengan Notifikasi Real-Time.
     */
    public function approve(Artwork $artwork)
    {
        if ($artwork->is_approved) {
            return redirect()->route('admin.moderation.index')->with('error', 'Karya ini sudah disetujui sebelumnya.');
        }

        $artwork->update(['is_approved' => true]);

        // Kirim notifikasi ke pemilik karya
        $artwork->user->notify(new ArtworkApprovedNotification($artwork));

        return redirect()->route('admin.moderation.index')
                         ->with('success', 'Karya seni "' . $artwork->title . '" berhasil disetujui dan notifikasi telah dikirim.');
    }

    /**
     * Toggle Select (Kurasi Galeri Terpilih)
     * Menggunakan save() manual untuk memastikan sinkronisasi database lebih akurat.
     */
    public function toggleSelect(Artwork $artwork)
    {
        // Pastikan karya sudah disetujui sebelum bisa dipilih masuk Galeri Terpilih
        if (!$artwork->is_approved) {
            return redirect()->route('admin.moderation.index')->with('error', 'Karya harus disetujui terlebih dahulu sebelum masuk Galeri Terpilih.');
        }

        // Membalikkan status boolean secara eksplisit
        $artwork->is_selected = !$artwork->is_selected;
        $artwork->save(); // Menggunakan save() untuk memastikan data masuk ke DB

        $status = $artwork->is_selected ? 'ditambahkan ke' : 'dihapus dari';

        return redirect()->route('admin.moderation.index')
                         ->with('success', "Karya seni \"{$artwork->title}\" berhasil {$status} Galeri Terpilih.");
    }

    /**
     * PERBAIKAN: Menolak (reject) Karya Seni dengan Alasan.
     * Alasan dikirim melalui notifikasi sebelum data dihapus.
     */
    public function reject(Request $request, Artwork $artwork)
    {
        // Validasi input alasan
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $title = $artwork->title;
        $reason = $request->reason;

        // 1. Kirim notifikasi penolakan ke seniman
        $artwork->user->notify(new ArtworkRejectedNotification($title, $reason));

        // 2. Hapus file dari storage
        if ($artwork->image_path) {
            Storage::disk('public')->delete($artwork->image_path);
        }

        // 3. Hapus data dari database
        $artwork->delete();

        return redirect()->route('admin.moderation.index')
                         ->with('success', 'Karya seni "' . $title . '" telah ditolak dan alasan telah dikirim ke seniman.');
    }
}