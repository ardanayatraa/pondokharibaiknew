<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use App\Mail\MailToParent;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\GuestController;
use App\Mail\MailToGuest;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;

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
// Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/villa', fn() => view('admin.villa'))->name('villa');
    Route::get('/season', fn() => view('admin.season'))->name('season');
    Route::get('/harga-villa', fn() => view('admin.harga-villa'))->name('harga-villa');
    Route::get('/akun-guest', fn() => view('admin.akun-guest'))->name('akun-guest');
    Route::get('/reservasi', fn() => view('admin.reservasi'))->name('reservasi');
    Route::get('/pembayaran', fn() => view('admin.pembayaran'))->name('pembayaran');
    Route::get('/laporan', fn() => view('admin.laporan'))->name('laporan');
});



// Owner
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', fn() => view('owner.dashboard'))->name('dashboard');
    Route::get('/laporan', fn() => view('owner.laporan'))->name('laporan');
    Route::get('/villa', fn() => view('owner.villa'))->name('villa'); // read-only view
});



// Guest
Route::middleware(['auth', 'role:guest'])->group(function () {
    // Route::get('/dashboard', fn() => view('guest.dashboard'))->name('dashboard');
    Route::get('/villa', fn() => view('guest.villa'))->name('villa');
    Route::get('/reservasi', fn() => view('guest.reservasi'))->name('reservasi');
    Route::get('/pembayaran', fn() => view('guest.pembayaran'))->name('pembayaran');
    Route::get('/pembayaran', fn() => view('guest.pembayaran'))->name('reservasi.create');
});

Route::get('/send', function () {
    // Dummy data untuk testing
    $nama    = 'Budi Santoso';
    $email   = 'madaryadev@gmail.com';

    // Kirim email menggunakan MailToGuest yang view-nya sudah berisi dummy
    Mail::to($email)->send(new MailToGuest($nama));

    return "Dummy email telah dikirim ke {$email} dengan nama “{$nama}”.";
});
