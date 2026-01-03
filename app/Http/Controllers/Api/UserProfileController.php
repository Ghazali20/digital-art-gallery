<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::with(['artworks' => function($query) {
            $query->where('is_approved', true);
        }])->find($id);

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ], 200);
    }
}