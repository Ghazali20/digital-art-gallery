<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Contest;

class DashboardController extends Controller
{
    public function index() {
        return response()->json([
            'status' => 'success',
            'data' => [
                'total_karya' => Artwork::count(),
                'total_kompetisi' => Contest::count(),
                'server_time' => now()->toDateTimeString()
            ]
        ], 200);
    }
}