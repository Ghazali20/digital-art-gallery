<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    public function index() {
        return response()->json(Artwork::all(), 200);
    }

    public function create() {
        return response()->json([
            'status' => 'success',
            'message' => 'Gunakan metode POST pada /api/artworks untuk menambah data.',
            'required_fields' => ['title', 'description', 'image_path', 'category_id', 'user_id']
        ], 200);
    }

    // Perbaikan fungsi store agar tidak error 500
    public function store(Request $request) {
        $data = $request->all();

        // Memberikan nilai default jika data tidak dikirim di Postman
        if (!isset($data['user_id'])) {
            $data['user_id'] = 1;
        }
        if (!isset($data['category_id'])) {
            $data['category_id'] = 1;
        }

        $artwork = Artwork::create($data);
        return response()->json(['message' => 'Karya berhasil ditambah!', 'data' => $artwork], 201);
    }

    public function show($id) {
        $artwork = Artwork::find($id);
        if (!$artwork) {
            return response()->json(['status' => 'error', 'message' => 'Karya tidak ditemukan.'], 404);
        }
        return response()->json($artwork, 200);
    }

    public function update(Request $request, $id) {
        $artwork = Artwork::findOrFail($id);
        $artwork->update($request->all());
        return response()->json(['message' => 'Karya berhasil diupdate!', 'data' => $artwork], 200);
    }

    public function destroy($id) {
        Artwork::destroy($id);
        return response()->json(['message' => 'Karya berhasil dihapus!'], 200);
    }
}