<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; 

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user sudah login (Auth::check())
        // 2. Pastikan role user adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            // Jika kondisi terpenuhi, izinkan request untuk dilanjutkan
            return $next($request);
        }

        // Jika user tidak login atau role-nya bukan 'admin'

        // Redirect ke halaman dashboard atau halaman utama dengan pesan error
        return redirect('/dashboard')->with('error', 'Akses Ditolak. Anda tidak memiliki izin Admin.');

        // Atau, jika Anda ingin menampilkan halaman 403 Forbidden:
        // abort(403, 'Unauthorized action.');
    }
}