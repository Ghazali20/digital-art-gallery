<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Tampil Semua Daftar Moderasi (GET /api/admin/moderation)
    public function moderationList() {
        return response()->json(Artwork::all(), 200);
    }

    // Tampil Detail Moderasi (GET /api/admin/moderation/{id})
    public function showModeration($id) {
        $artwork = Artwork::find($id);

        if (!$artwork) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data moderasi tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $artwork
        ], 200);
    }

    // Aksi Persetujuan (POST /api/admin/moderation/{id}/approve)
    public function approveArtwork($id) {
        $artwork = Artwork::find($id);

        if (!$artwork) {
            return response()->json(['message' => 'Karya tidak ditemukan'], 404);
        }

        // Pastikan kolom 'status' ada di tabel artworks Anda
        $artwork->update(['status' => 'approved']);
        return response()->json(['message' => 'Karya berhasil disetujui'], 200);
    }
}