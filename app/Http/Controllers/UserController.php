<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan formulir bagi user untuk mendaftar sebagai Peserta.
     */
    public function createPesertaApplication(): View | RedirectResponse
    {
        $user = Auth::user();

        // Validasi: Jika sudah Peserta/Admin, redirect saja
        if ($user->role !== 'user') {
            return redirect()->route('dashboard')->with('error', 'Akun Anda sudah berstatus ' . $user->role . ' dan tidak memerlukan pendaftaran tambahan.');
        }

        // Tampilkan halaman aplikasi
        return view('user.peserta-application');
    }

    /**
     * Memproses permintaan untuk meng-upgrade role user dari 'user' menjadi 'peserta'.
     */
    public function upgradeToPeserta(): RedirectResponse
    {
        $user = Auth::user();

        // 1. Validasi: Hanya role 'user' yang bisa diupgrade
        if ($user->role !== 'user') {
            return redirect()->back()->with('error', 'Akun Anda sudah berstatus ' . $user->role . ' atau tidak dapat diupgrade.');
        }

        // 2. Lakukan perubahan role di database
        $user->role = 'peserta';

        // === TAMBAHAN LOGIKA BARU: Update Nama Akun ===
        $currentName = $user->name;

        // Cek apakah nama sudah memiliki label (untuk mencegah duplikasi jika kode dijalankan dua kali)
        // Kita gunakan str_ends_with()
        if (!str_ends_with($currentName, ' (Peserta)')) {
            $user->name = $currentName . ' (Peserta)';
        }
        // ===============================================

        // Karena Anda sudah menjalankan migration, kolom 'role' kini cukup panjang (misal VARCHAR(20))
        // untuk menyimpan string 'peserta' tanpa error truncation (Warning: 1265)
        $user->save();

        // 3. Redirect ke dashboard dengan notifikasi sukses, mencantumkan nama baru
        return redirect()->route('dashboard')->with('success', 'Selamat! Akun Anda telah berhasil di-upgrade menjadi Peserta. Nama akun Anda sekarang: **' . $user->name . '**. Anda kini dapat mengunggah karya dan ikut kontes.');
    }
}