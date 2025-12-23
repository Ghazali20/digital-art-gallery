<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;

class GalleryController extends Controller
{

    public function index() {
        $artworks = Artwork::all();
        return response()->json([
            'status' => 'success',
            'data' => $artworks
        ], 200);
    }

    public function show($id) {
        $artwork = Artwork::find($id);

        if ($artwork) {
            return response()->json([
                'status' => 'success',
                'message' => 'Detail karya ditemukan',
                'data' => $artwork
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Karya dengan ID ' . $id . ' tidak ditemukan'
            ], 404);
        }
    }
}