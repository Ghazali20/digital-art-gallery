<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    public function index()
    {
        $artworks = Artwork::where('user_id', Auth::id())
                          ->with('category')
                          ->orderBy('created_at', 'desc')
                          ->get();

        return view('artworks.index', compact('artworks'));
    }

    public function create()
    {
        // === VALIDASI ROLE: Hanya Admin yang dilarang mengakses form upload ===
        if (Auth::user()->role === 'admin') {
            return redirect()->route('artworks.index')
                             ->with('error', 'Administrator tidak diizinkan mengunggah karya di Galeri Pribadi.');
        }
        // ===============================================================================

        $categories = Category::all();
        return view('artworks.create', compact('categories'));
    }

    /**
     * Menyimpan Karya Seni baru ke database dan menyimpan file gambar.
     */
    public function store(Request $request)
    {
        // === VALIDASI ROLE: Hanya Admin yang dilarang menyimpan karya ===
        if (Auth::user()->role === 'admin') {
            return redirect()->route('artworks.index')
                             ->with('error', 'Akses ditolak. Administrator tidak dapat membuat karya di Galeri Pribadi.');
        }
        // ========================================================================

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image_file')->store('artworks', 'public');

        Artwork::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_approved' => false,
        ]);

        return redirect()->route('artworks.index')->with('success', 'Karya berhasil diunggah dan menunggu moderasi Admin.');
    }

    /**
     * Menampilkan detail satu karya seni (Untuk rute artworks.show).
     */
    public function show(Artwork $artwork)
    {
        // Otorisasi: Karya harus disetujui ATAU user adalah pemilik karya ATAU user adalah admin.
        if (!$artwork->is_approved) {
            if (!Auth::check() || (Auth::id() !== $artwork->user_id && Auth::user()->role !== 'admin')) {
                // Jika tidak disetujui, dan user BUKAN pemilik atau BUKAN admin, tolak akses.
                abort(404);
            }
        }

        // Muat likes count untuk ditampilkan di view detail
        // DIHAPUS: $artwork->loadCount('likers');

        return view('artworks.show', compact('artwork'));
    }


    /**
     * Menampilkan form untuk mengedit Karya Seni.
     */
    public function edit(Artwork $artwork)
    {
        // Logika Otorisasi Disempurnakan
        $isOwner = Auth::id() === $artwork->user_id;
        $isAdmin = Auth::user()->role === 'admin';

        // Cek 1: Jika user bukan pemilik DAN bukan admin, tolak.
        if (!$isOwner && !$isAdmin) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit karya ini.');
        }

        // Cek 2: Admin dilarang mengedit karyanya sendiri di sini (harus melalui Moderasi).
        if ($isAdmin && $isOwner) {
             abort(403, 'Administrator harus menggunakan fitur Moderasi untuk mengelola karyanya sendiri.');
        }

        $categories = Category::all();
        return view('artworks.edit', compact('artwork', 'categories'));
    }

    /**
     * Memperbarui Karya Seni di database.
     */
    public function update(Request $request, Artwork $artwork)
    {
        // Logika Otorisasi Disempurnakan
        $isOwner = Auth::id() === $artwork->user_id;
        $isAdmin = Auth::user()->role === 'admin';

        // Cek 1: Jika user bukan pemilik DAN bukan admin, tolak.
        if (!$isOwner && !$isAdmin) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui karya ini.');
        }

        // Cek 2: Admin dilarang mengupdate karyanya sendiri di sini (harus melalui Moderasi).
        if ($isAdmin && $isOwner) {
             abort(403, 'Administrator harus menggunakan fitur Moderasi untuk mengelola karyanya sendiri.');
        }

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $request->validate($rules);

        $imagePath = $artwork->image_path;

        if ($request->hasFile('image_file')) {
            Storage::disk('public')->delete($artwork->image_path);
            $imagePath = $request->file('image_file')->store('artworks', 'public');
        }

        $artwork->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('artworks.index')->with('success', 'Karya berhasil diperbarui.');
    }

    /**
     * Menghapus Karya Seni dari database dan storage.
     */
    public function destroy(Artwork $artwork)
    {
        // Logika Otorisasi Disempurnakan
        $isOwner = Auth::id() === $artwork->user_id;
        $isAdmin = Auth::user()->role === 'admin';

        // Cek 1: Jika user bukan pemilik DAN bukan admin, tolak.
        if (!$isOwner && !$isAdmin) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus karya ini.');
        }

        // Cek 2: Admin dilarang menghapus karyanya sendiri di sini (harus melalui Moderasi).
        if ($isAdmin && $isOwner) {
             abort(403, 'Administrator harus menggunakan fitur Moderasi untuk mengelola karyanya sendiri.');
        }

        Storage::disk('public')->delete($artwork->image_path);

        $artwork->delete();

        return redirect()->route('artworks.index')->with('success', 'Karya berhasil dihapus.');
    }
}