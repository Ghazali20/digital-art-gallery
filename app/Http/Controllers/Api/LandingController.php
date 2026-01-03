<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index() {
        return response()->json([
            'status' => 'success',
            'app_name' => 'Digital Art Gallery API',
            'version' => '1.0.0',
            'endpoints' => [
                'auth' => '/api/login, /api/register',
                'resources' => '/api/artworks, /api/categories, /api/contests',
                'admin' => '/api/admin/moderation'
            ]
        ], 200);
    }
}