<?php

use App\Http\Controllers\VillaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailToGuest;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\VillaPricingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\ResepsionisDashboardController;
use App\Http\Controllers\CekKetersediaanResepsionisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [BookingController::class, 'index'])->name('home.index');

Route::post('/login', [CustomAuthenticatedSessionController::class, 'store'])->name('login');
Route::post('/register', [GuestController::class, 'store'])->name('guests.store');
Route::post('/logout', [CustomAuthenticatedSessionController::class, 'destroy'])->name('logout');


Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Admin Group
Route::middleware(['auth'])->group(function () {

    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');
    Route::get('/report/export', [ReportController::class, 'export'])->name('report.export');


    // Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('show');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
    });

    // Facility
    Route::prefix('facility')->name('facility.')->group(function () {
        Route::get('/', [FacilityController::class, 'index'])->name('index');
        Route::get('/create', [FacilityController::class, 'create'])->name('create');
        Route::post('/', [FacilityController::class, 'store'])->name('store');
        Route::get('/{facility}', [FacilityController::class, 'show'])->name('show');
        Route::get('/{facility}/edit', [FacilityController::class, 'edit'])->name('edit');
        Route::put('/{facility}', [FacilityController::class, 'update'])->name('update');
        Route::delete('/{facility}', [FacilityController::class, 'destroy'])->name('destroy');
    });

    // Guest
        Route::prefix('guest')->name('guest.')->group(function () {
            Route::get('/', [GuestController::class, 'index'])->name('index');
            Route::get('/create', [GuestController::class, 'create'])->name('create');
            Route::post('/', [GuestController::class, 'store'])->name('store');
            Route::get('/{guest}', [GuestController::class, 'show'])->name('show');
            Route::get('/{guest}/edit', [GuestController::class, 'edit'])->name('edit');
            Route::put('/{guest}', [GuestController::class, 'update'])->name('update');
            Route::delete('/{guest}', [GuestController::class, 'destroy'])->name('destroy');
        });


    // Owner
    Route::prefix('owner')->name('owner.')->group(function () {
        Route::get('/', [OwnerController::class, 'index'])->name('index');
        Route::get('/create', [OwnerController::class, 'create'])->name('create');
        Route::post('/', [OwnerController::class, 'store'])->name('store');
        Route::get('/{owner}', [OwnerController::class, 'show'])->name('show');
        Route::get('/{owner}/edit', [OwnerController::class, 'edit'])->name('edit');
        Route::put('/{owner}', [OwnerController::class, 'update'])->name('update');
        Route::delete('/{owner}', [OwnerController::class, 'destroy'])->name('destroy');
    });

    // Pembayaran
    Route::prefix('pembayaran')->name('pembayaran.')->group(function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::get('/create', [PembayaranController::class, 'create'])->name('create');
        Route::post('/', [PembayaranController::class, 'store'])->name('store');
        Route::get('/{pembayaran}', [PembayaranController::class, 'show'])->name('show');
        Route::get('/{pembayaran}/edit', [PembayaranController::class, 'edit'])->name('edit');
        Route::put('/{pembayaran}', [PembayaranController::class, 'update'])->name('update');
        Route::delete('/{pembayaran}', [PembayaranController::class, 'destroy'])->name('destroy');
    });

    // Report
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/create', [ReportController::class, 'create'])->name('create');
        Route::post('/', [ReportController::class, 'store'])->name('store');
        Route::get('/{report}', [ReportController::class, 'show'])->name('show');
        Route::get('/{report}/edit', [ReportController::class, 'edit'])->name('edit');
        Route::put('/{report}', [ReportController::class, 'update'])->name('update');
        Route::delete('/{report}', [ReportController::class, 'destroy'])->name('destroy');
    });

    // Reservasi
    Route::prefix('reservasi')->name('reservasi.')->group(function () {
        Route::get('/', [ReservasiController::class, 'index'])->name('index');
        Route::get('/create', [ReservasiController::class, 'create'])->name('create');
        Route::post('/', [ReservasiController::class, 'store'])->name('store');
        Route::get('/{reservasi}', [ReservasiController::class, 'show'])->name('show');
        Route::get('/{reservasi}/edit', [ReservasiController::class, 'edit'])->name('edit');
        Route::put('/{reservasi}', [ReservasiController::class, 'update'])->name('update');
        Route::delete('/{reservasi}', [ReservasiController::class, 'destroy'])->name('destroy');
    });

    // Season
    Route::prefix('season')->name('season.')->group(function () {
        Route::get('/', [SeasonController::class, 'index'])->name('index');
        Route::get('/create', [SeasonController::class, 'create'])->name('create');
        Route::post('/', [SeasonController::class, 'store'])->name('store');
        Route::get('/{season}', [SeasonController::class, 'show'])->name('show');
        Route::get('/{season}/edit', [SeasonController::class, 'edit'])->name('edit');
        Route::put('/{season}', [SeasonController::class, 'update'])->name('update');
        Route::delete('/{season}', [SeasonController::class, 'destroy'])->name('destroy');
    });

    // Villa
    Route::prefix('villa')->name('villa.')->group(function () {
        Route::get('/', [VillaController::class, 'index'])->name('index');
        Route::get('/create', [VillaController::class, 'create'])->name('create');
        Route::post('/', [VillaController::class, 'store'])->name('store');

        Route::get('/{villa}/edit', [VillaController::class, 'edit'])->name('edit');
        Route::put('/{villa}', [VillaController::class, 'update'])->name('update');
        Route::delete('/{villa}', [VillaController::class, 'destroy'])->name('destroy');
    });

    // Harga Villa
    Route::prefix('harga-villa')->name('harga-villa.')->group(function () {
        Route::get('/', [VillaPricingController::class, 'index'])->name('index');
        Route::get('/create', [VillaPricingController::class, 'create'])->name('create');
        Route::post('/', [VillaPricingController::class, 'store'])->name('store');
        Route::get('/{harga_villa}', [VillaPricingController::class, 'show'])->name('show');
        Route::get('/{harga_villa}/edit', [VillaPricingController::class, 'edit'])->name('edit');
        Route::put('/{harga_villa}', [VillaPricingController::class, 'update'])->name('update');
        Route::delete('/{harga_villa}', [VillaPricingController::class, 'destroy'])->name('destroy');
    });
});

// Resepsionis Group
Route::middleware(['auth:admin', 'role:resepsionis'])->prefix('resepsionis')->name('resepsionis.')->group(function () {
    Route::get('/dashboard', [ResepsionisDashboardController::class, 'index'])->name('dashboard');
    Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan');
    Route::get('/cek-ketersediaan', [CekKetersediaanResepsionisController::class, 'index'])->name('cek-ketersediaan');
});

// Dummy mail tester
Route::get('/send', function () {
    $nama  = 'Budi Santoso';
    $email = 'madaryadev@gmail.com';

    Mail::to($email)->send(new MailToGuest($nama));

    return "Dummy email telah dikirim ke {$email} dengan nama “{$nama}”.";
})->name('mail.test');
Route::get('/refund/status/{orderId}', [RefundController::class, 'checkRefundStatus']);

Route::get('/villa/{id}', [BookingController::class, 'villabyId']);
Route::get('/villa/{villa}/reserved-dates', [BookingController::class, 'reservedDates']);
Route::get('/villa/{villa}/calculate', [BookingController::class, 'calculate']);
  Route::get('/reservation/{id}/reschedule-data', [BookingController::class, 'getReservationForReschedule']);
    Route::get('/reservation/{id}/calculate-reschedule', [BookingController::class, 'calculateReschedule']);
    Route::post('/reservation/reschedule', [BookingController::class, 'processReschedule']);
Route::middleware(['auth', 'role:guest'])->get('/guestbyID/{id}', [App\Http\Controllers\BookingController::class, 'guestInfo']);
Route::post('/payment/token', [BookingController::class,'paymentToken']);

    Route::middleware(['auth:guest'])->group(function () {

 Route::post('/reservation/store', [BookingController::class,'storeReservation']);
    Route::get('/reservation/{id}/refund-info', [RefundController::class, 'getRefundInfo']);
    Route::post('/reservation/refund', [RefundController::class, 'processRefund']);
    // Change to updateUser route
    Route::post('/updateUser', [GuestController::class, 'updateUser'])->name('guest.updateUser');
});



