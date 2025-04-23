<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use App\Mail\MailToParent;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GuestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing-page');
});


Route::post('/login', [CustomAuthenticatedSessionController::class, 'store'])->name('login');

Route::post('/register', [GuestController::class, 'store'])->name('guests.store');

Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/data-akun', function () {
        return view('admin.data-account');
    })->name('admin.data-account');
});

// Guru
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', function () {
        return view('owner.dashboard');
    })->name('owner.dashboard');
    Route::get('/owner/aspek-penilaian', function () {
        return view('owner.aspek-penilaian');
    })->name('owner.aspek-penilaian');
    Route::get('/owner/kategori', function () {
        return view('owner.kategori');
    })->name('owner.kategori');
    Route::get('/owner/penilaian', function () {
        return view('owner.penilaian');
    })->name('owner.penilaian');
    Route::get('/owner/penilaian/{id}', function ($id) {
        return view('owner.penilaian-detail', ['id' => $id]);
    })->name('owner.penilaian.detail');
});

// Siswa
Route::middleware(['auth', 'role:guest'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard.guest');
});



Route::get('/kirim', function () {
    $namaAnak = 'Made';
    $emailOrtu = 'ardanapastibisa@gmail.com';

    Mail::to($emailOrtu)->send(new MailToParent($namaAnak));

    return 'Email plus lampiran berhasil dikirim ke orang tua dari ' . $namaAnak;
});
