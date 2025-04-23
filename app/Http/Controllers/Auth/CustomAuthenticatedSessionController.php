<?php

namespace App\Http\Controllers\Auth;

use Symfony\Component\HttpFoundation\Response;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyController;
use Laravel\Fortify\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Responses\LogoutResponse;

class CustomAuthenticatedSessionController extends FortifyController
{
// di CustomAuthenticatedSessionController.php
public function store(LoginRequest $request)
{
    $response = parent::store($request);

    $user = auth()->user();

    // Set role manual berdasarkan class user-nya
    $role = match (get_class($user)) {
        \App\Models\Admin::class => 'admin',
        \App\Models\Owner::class => 'owner',
        \App\Models\Guest::class => 'guest',
        default => 'guest',
    };

    session(['role' => $role]);

    $redirectTo = match ($role) {
        'admin' => '/admin/dashboard',
        'owner' => '/owner/dashboard',
        'guest' => '/dashboard',
        default => '/',
    };

    return redirect()->intended($redirectTo);

    }


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
