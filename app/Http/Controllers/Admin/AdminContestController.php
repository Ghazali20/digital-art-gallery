<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\Request;

class AdminContestController extends Controller 
{
    /**
     * Menampilkan daftar semua Kontes (Read/Index).
     */
    public function index()
    {
        // Ambil semua kontes, termasuk yang sudah berakhir atau tidak aktif
        $contests = Contest::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contests.index', compact('contests'));
    }

    /**
     * Menampilkan form untuk membuat Kontes baru (Create).
     */
    public function create()
    {
        return view('admin.contests.create');
    }

    /**
     * Menyimpan Kontes baru ke database (Store).
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            // Checkbox akan mengirim 1 atau 0, jadi boolean/nullable
            'is_active' => 'boolean',
        ]);

        // Pastikan is_active diset ke 0 jika tidak ada di request (untuk checkbox yang tidak dicentang)
        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        Contest::create($data);

        return redirect()->route('admin.contests.index')->with('success', 'Kontes baru berhasil dibuat.');
    }

    /**
     * Menampilkan detail Kontes (Show) - Opsional, biasanya di-redirect ke edit.
     */
    public function show(Contest $contest)
    {
        return redirect()->route('admin.contests.edit', $contest);
    }

    /**
     * Menampilkan form untuk mengedit Kontes (Edit).
     */
    public function edit(Contest $contest)
    {
        return view('admin.contests.edit', compact('contest'));
    }

    /**
     * Memperbarui Kontes di database (Update).
     */
    public function update(Request $request, Contest $contest)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $contest->update($data);

        return redirect()->route('admin.contests.index')->with('success', 'Kontes berhasil diperbarui.');
    }

    /**
     * Menghapus Kontes dari database (Destroy).
     */
    public function destroy(Contest $contest)
    {
        $contest->delete();
        return redirect()->route('admin.contests.index')->with('success', 'Kontes berhasil dihapus.');
    }
}