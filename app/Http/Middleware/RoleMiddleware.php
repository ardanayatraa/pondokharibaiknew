<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Cek apakah role di session tidak sesuai dengan role yang diharapkan
        if (session('role') !== $role) {
            // Jika role tidak sesuai, arahkan ke dashboard yang sesuai berdasarkan session role
            $role = session('role');  // Ambil role dari session
            $redirectTo = match ($role) {
                'admin' => '/admin/dashboard',
                'owner' => '/owner/dashboard',
                'guest' => '/',
                default => '/',
            };

            return redirect($redirectTo); // Redirect ke halaman dashboard yang sesuai
        }

        return $next($request); // Jika role sesuai, lanjutkan ke proses selanjutnya
    }
}
