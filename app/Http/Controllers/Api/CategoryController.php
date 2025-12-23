<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index() {
        return response()->json(Category::all(), 200);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        // Otomatis buat slug jika kolom slug ada di database Anda
        $data['slug'] = Str::slug($request->name);

        $category = Category::create($data);
        return response()->json(['message' => 'Kategori berhasil dibuat', 'data' => $category], 201);
    }

    public function show($id) {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        return response()->json($category, 200);
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->update($request->all());
        return response()->json(['message' => 'Kategori diperbarui', 'data' => $category], 200);
    }

    public function destroy($id) {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Kategori dihapus'], 200);
    }
}