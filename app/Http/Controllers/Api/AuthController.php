<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan info Register (GET /api/register)
    public function registerInfo() {
        return response()->json([
            'status' => 'success',
            'message' => 'Silakan kirimkan name, email, dan password melalui POST untuk mendaftar.'
        ]);
    }

    // Menampilkan info Login (GET /api/login)
    public function loginInfo() {
        return response()->json([
            'status' => 'success',
            'message' => 'Silakan kirimkan email dan password melalui POST untuk masuk.'
        ]);
    }

    // Contoh fungsi Store untuk Register (POST /api/register)
    public function storeRegister(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['message' => 'User berhasil dibuat melalui API', 'data' => $user], 201);
    }
}