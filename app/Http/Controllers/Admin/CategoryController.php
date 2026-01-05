<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar semua Kategori.
     */
    public function index()
    {
        $categories = Category::orderBy('name', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat Kategori baru.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Menyimpan Kategori baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // 2. Simpan Data
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail Kategori (Opsional, jarang dipakai untuk kategori sederhana).
     */
    public function show(Category $category)
    {
        // Untuk kategori sederhana, kita bisa langsung redirect ke index
        return redirect()->route('admin.categories.index');
    }

    /**
     * Menampilkan form untuk mengedit Kategori.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Memperbarui Kategori di database.
     */
    public function update(Request $request, Category $category)
    {
        // 1. Validasi Input (Pastikan name unik, kecuali untuk dirinya sendiri)
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        // 2. Update Data
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Menghapus Kategori dari database.
     */
    public function destroy(Category $category)
    {

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}