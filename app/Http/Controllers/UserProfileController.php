<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk mengelola file
use Illuminate\Support\Facades\Redirect;

class UserProfileController extends Controller
{
    /**
     * Menampilkan halaman profil publik
     */
    public function show($id)
    {
        // Mengambil user beserta karyanya yang sudah disetujui
        $user = User::with(['artworks' => function($query) {
            $query->where('is_approved', true);
        }])->findOrFail($id);

        return view('profile.show', [
            'user' => $user,
            'artworks' => $user->artworks
        ]);
    }

    /**
     * Menampilkan formulir edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Menyimpan perubahan profil (Versi Diperbarui)
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validasi field baru: bio, profile_photo, instagram, dan portfolio
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'bio' => ['nullable', 'string', 'max:500'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'instagram_handle' => ['nullable', 'string', 'max:50'],
            'portfolio_link' => ['nullable', 'url', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        // Mengelola Unggahan Foto Profil
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada untuk menghemat ruang storage
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan foto baru ke folder 'profiles' di disk public
            $path = $request->file('profile_photo')->store('profiles', 'public');
            $user->profile_photo = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->bio = $request->bio;
        $user->instagram_handle = $request->instagram_handle;
        $user->portfolio_link = $request->portfolio_link;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.show', $user->id)->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /**
     * Menghapus akun pengguna
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Hapus file foto profil jika user menghapus akun
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}