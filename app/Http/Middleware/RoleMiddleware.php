<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $expectedRole)
    {
        $sessionRole = session('role') ;

        // Jika role tidak sesuai
        if ($sessionRole !== $expectedRole) {
            // Kalau role guest → ke /
            if ($sessionRole === 'guest') {
                return redirect('/');
            }

            // Kalau role admin atau owner atau lainnya → ke /dashboard
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
