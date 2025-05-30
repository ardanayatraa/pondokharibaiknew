<?php

use App\Http\Controllers\GuestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['web', 'auth:guest'])->group(function () {
    // PUT /api/guest/profile  → akan dijaga oleh guard 'guest'
    Route::put('/guest/profile', [GuestController::class, 'apiUpdateProfile'])
         ->name('api.guest.updateProfile');
});
