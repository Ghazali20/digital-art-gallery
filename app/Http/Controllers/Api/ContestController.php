<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use Illuminate\Http\Request;

class ContestController extends Controller
{
    public function index() {
        return response()->json(Contest::all(), 200);
    }

    public function show($id) {
        $contest = Contest::find($id);
        if (!$contest) {
            return response()->json(['status' => 'error', 'message' => 'Kontes tidak ditemukan'], 404);
        }
        return response()->json(['status' => 'success', 'data' => $contest], 200);
    }

    public function store(Request $request) {
        $data = $request->all();
        // Jika is_active tidak dikirim, default ke true (1)
        $data['is_active'] = $request->has('is_active') ? $request->is_active : 1;

        $contest = Contest::create($data);
        return response()->json(['message' => 'Kontes berhasil ditambah', 'data' => $contest], 201);
    }

    public function update(Request $request, $id) {
        $contest = Contest::find($id);
        if (!$contest) {
            return response()->json(['message' => 'Kontes tidak ditemukan'], 404);
        }

        $data = $request->all();

        // PERBAIKAN: Memastikan nilai 0 masuk jika checkbox tidak dicentang
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $contest->update($data);

        // Jika request dari Postman/AJAX (ingin JSON)
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Kontes diperbarui', 'data' => $contest], 200);
        }

        // Jika dari Form Web biasa, kembali ke halaman indeks
        return redirect()->route('admin.contests.index')->with('success', 'Kontes berhasil diperbarui');
    }

    public function destroy($id) {
        $contest = Contest::find($id);
        if (!$contest) {
            return response()->json(['message' => 'Kontes tidak ditemukan'], 404);
        }

        $contest->delete();
        return response()->json(['message' => 'Kontes dihapus'], 200);
    }
}