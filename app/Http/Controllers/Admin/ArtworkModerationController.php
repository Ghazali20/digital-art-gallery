<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; 

class ArtworkModerationController extends Controller
{
    /**
     * Menampilkan daftar Karya Seni yang MENUNGGU moderasi.
     */
    public function index()
    {
        $artworks = Artwork::where('is_approved', false)
                          ->with('user', 'category')
                          ->orderBy('created_at', 'asc')
                          ->paginate(10);

        return view('admin.moderation.index', compact('artworks'));
    }

    /**
     * Memproses persetujuan (approval) Karya Seni.
     */
    public function approve(Artwork $artwork)
    {
        if ($artwork->is_approved) {
            return redirect()->route('admin.moderation.index')->with('error', 'Karya ini sudah disetujui sebelumnya.');
        }

        $artwork->update(['is_approved' => true]);

        return redirect()->route('admin.moderation.index')->with('success', 'Karya seni "' . $artwork->title . '" berhasil disetujui dan kini aktif.');
    }

    /**
     * Menolak (reject) Karya Seni dan menghapusnya.
     */
    public function reject(Artwork $artwork)
    {
        // Admin menghapus karya secara permanen jika ditolak

        // Hapus file dari storage
        Storage::disk('public')->delete($artwork->image_path);

        $title = $artwork->title;
        $artwork->delete();

        return redirect()->route('admin.moderation.index')->with('success', 'Karya seni "' . $title . '" telah ditolak dan dihapus dari sistem.');
    }
}