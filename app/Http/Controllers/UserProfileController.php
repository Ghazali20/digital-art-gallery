<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Artwork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // Tambahkan ini

class UserProfileController extends Controller
{
    /**
     * Menampilkan halaman profil publik
     */
    public function show($id)
    {
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
     * Menyimpan perubahan profil
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

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

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}