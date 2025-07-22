<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Laravel\Fortify\Http\Responses\LogoutResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyController;

class CustomAuthenticatedSessionController extends FortifyController
{
    /**
     * Override login handler untuk redirect berdasarkan role user.
     */
    public function store(LoginRequest $request)
    {
        try {
            // Jalankan login default dari Fortify
            $response = parent::store($request);

            // Ambil user yang sudah login
            $user = auth()->user();

            // Tentukan role berdasarkan model dan tipe
            if ($user instanceof \App\Models\Admin) {
                $role = $user->tipe; // bisa "admin" atau "resepsionis"
            } elseif ($user instanceof \App\Models\Owner) {
                $role = 'owner';
            } elseif ($user instanceof \App\Models\Guest) {
                $role = 'guest';
            } else {
                $role = 'guest';
            }

            // Simpan role ke session
            session(['role' => $role]);

            // Tentukan redirect berdasarkan role
            $redirectTo = match ($role) {
                'admin' => '/dashboard',
                'owner' => '/dashboard',
                'resepsionis' => '/resepsionis/dashboard',
                'guest' => '/',
                default => '/',
            };

            return redirect()->intended($redirectTo);
        } catch (Throwable $e) {
            // Login gagal — redirect kembali dengan error
            return redirect()
                ->back()
                ->withInput($request->only('username'))
                ->withErrors([
                    'username' => 'Login gagal. Periksa kembali username dan password.',
                ]);
        }
    }

    /**
     * Override logout handler agar semua guard dibersihkan.
     */
    public function destroy(Request $request): LogoutResponse
    {
        auth()->guard('web')->logout();
        auth()->guard('admin')->logout();
        auth()->guard('guest')->logout();
        auth()->guard('owner')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('role');

        return app(LogoutResponse::class);
    }
}
        