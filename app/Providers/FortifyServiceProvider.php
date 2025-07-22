<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\AkunSiswa;
use App\Models\Guest;
use App\Models\Guru;
use App\Models\KepalaSekolah;
use App\Models\Owner;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Fortify::username(function () {
            return 'username';
        });


        Fortify::authenticateUsing(function (Request $request) {
            $username = $request->input('username');
            $password = $request->input('password');

            // Cek dari tabel akun_siswa
            $guest = Guest::where('username', $username)->first();
            if ($guest && Hash::check($password, $guest->password)) {
                session(['role' => 'guest']);
                Auth::guard('guest')->login($guest); // Login dengan guard guest
                return $guest;
            }

            // Cek dari tabel owner
            $owner = Owner::where('username', $username)->first();
            if ($owner && Hash::check($password, $owner->password)) {
                session(['role' => 'owner']);
                Auth::guard('owner')->login($owner); // Login dengan guard owner
                return $owner;
            }

            // Cek dari tabel admin
            $admin = Admin::where('username', $username)->first();
            if ($admin && Hash::check($password, $admin->password)) {
                $role = $admin->tipe === 'resepsionis' ? 'resepsionis' : 'admin';
                session(['role' => $role]);
                Auth::guard('admin')->login($admin); // Login dengan guard admin
                \Log::info('LOGIN ADMIN', [
                    'user' => $admin,
                    'guard_admin_check' => Auth::guard('admin')->check(),
                    'session_role' => session('role'),
                    'all_session' => session()->all(),
                ]);
                return $admin;
            }

            return null;
        });




        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            return view('auth.login'); // Ubah kalau mau pake view lain
        });

    }
}
