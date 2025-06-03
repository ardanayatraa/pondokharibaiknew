<?php

namespace App\Http\Controllers\Auth;

use Throwable;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyController;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Responses\LogoutResponse;

class CustomAuthenticatedSessionController extends FortifyController
{
    // Override method store agar kita bisa tangani error tanpa exception
    public function store(LoginRequest $request)
    {
        try {
            // Cobalah jalankan login sesuai Fortify
            $response = parent::store($request);

            // Jika berhasil login, ambil user dan set session role
            $user = auth()->user();

            $role = match (get_class($user)) {
                \App\Models\Admin::class => 'admin',
                \App\Models\Owner::class => 'owner',
                \App\Models\Guest::class => 'guest',
                default => 'guest',
            };

            session(['role' => $role]);

            $redirectTo = match ($role) {
                'admin' => '/dashboard',
                'owner' => '/dashboard',
                'guest' => '/',
                default => '/',
            };

            return redirect()->intended($redirectTo);
        }
        catch (Throwable $e) {
            // Jika ada error (misalnya kredensial salah atau error internal),
            // kita log (opsional) lalu redirect kembali dengan pesan.


            return redirect()
                ->back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Login gagal. Periksa kembali email dan password.',
                ]);
        }
    }

    // Override destroy untuk logout bersih (tidak butuh perubahan besar)
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
