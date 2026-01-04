<?php

namespace App\Http\Controllers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\User; // Tambahkan import User untuk mencari Admin
use App\Notifications\NewArtworkSubmittedNotification; // Import Notifikasi Baru
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ArtworkController extends Controller
{
    /**
     * Menampilkan daftar karya dengan fitur Pencarian dan Filter Kategori.
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi Query: Ambil karya milik user yang sedang login
        $query = Artwork::where('user_id', Auth::id())->with('category');

        // 2. Fitur Pencarian: Berdasarkan Judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 3. Fitur Filter: Berdasarkan ID Kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // 4. Eksekusi Query dengan Pengurutan Terbaru
        $artworks = $query->orderBy('created_at', 'desc')->get();

        // 5. Ambil semua kategori untuk ditampilkan di dropdown filter
        $categories = Category::all();

        return view('artworks.index', compact('artworks', 'categories'));
    }

    public function create()
    {
        // === VALIDASI ROLE: Hanya Admin yang dilarang mengakses form upload ===
        if (Auth::user()->role === 'admin') {
            return redirect()->route('artworks.index')
                             ->with('error', 'Administrator tidak diizinkan mengunggah karya di Galeri Pribadi.');
        }

        $categories = Category::all();
        return view('artworks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // === VALIDASI ROLE: Hanya Admin yang dilarang menyimpan karya ===
        if (Auth::user()->role === 'admin') {
            return redirect()->route('artworks.index')
                             ->with('error', 'Akses ditolak. Administrator tidak dapat membuat karya di Galeri Pribadi.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('image_file')->store('artworks', 'public');

        $artwork = Artwork::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'is_approved' => false,
        ]);

        // === FITUR BARU: KIRIM NOTIFIKASI KE SEMUA ADMIN ===
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewArtworkSubmittedNotification($artwork));
        }
        // =========================================================================================

        return redirect()->route('artworks.index')->with('success', 'Karya berhasil diunggah dan menunggu moderasi Admin.');
    }

    public function show(Artwork $artwork)
    {
        // Otorisasi: Karya harus disetujui ATAU user adalah pemilik karya ATAU user adalah admin.
        if (!$artwork->is_approved) {
            if (!Auth::check() || (Auth::id() !== $artwork->user_id && Auth::user()->role !== 'admin')) {
                abort(404);
            }
        }

        return view('artworks.show', compact('artwork'));
    }

    public function edit(Artwork $artwork)
    {
        $isOwner = Auth::id() === $artwork->user_id;
        $isAdmin = Auth::user()->role === 'admin';

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit karya ini.');
        }

        if ($isAdmin && $isOwner) {
             abort(403, 'Administrator harus menggunakan fitur Moderasi untuk mengelola karyanya sendiri.');
        }

        $categories = Category::all();
        return view('artworks.edit', compact('artwork', 'categories'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        $isOwner = Auth::id() === $artwork->user_id;
        $isAdmin = Auth::user()->role === 'admin';

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Anda tidak memiliki izin untuk memperbarui karya ini.');
        }

        if ($isAdmin && $isOwner) {
             abort(403, 'Administrator harus menggunakan fitur Moderasi untuk mengelola karyanya sendiri.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

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

    public function destroy(Artwork $artwork)
    {
        $isOwner = Auth::id() === $artwork->user_id;
        $isAdmin = Auth::user()->role === 'admin';

        if (!$isOwner && !$isAdmin) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus karya ini.');
        }

        if ($isAdmin && $isOwner) {
             abort(403, 'Administrator harus menggunakan fitur Moderasi untuk mengelola karyanya sendiri.');
        }

        Storage::disk('public')->delete($artwork->image_path);
        $artwork->delete();

        return redirect()->route('artworks.index')->with('success', 'Karya berhasil dihapus.');
    }
}