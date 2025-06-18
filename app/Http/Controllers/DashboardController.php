<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use App\Models\Guest;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = session('role');

        // statistik
        $totalRoom         = Villa::count();
        $jumlahGuest       = Guest::count();
        $jumlahReservasi   = Reservasi::count();
        $jumlahCancel      = Reservasi::where('status', 'cancelled')->count();
        $jumlahReschedule  = Reservasi::where('status', 'reschedule')->count();
        $totalTransaksi    = Pembayaran::sum('amount');

        return match ($role) {
            'admin'  => view('dashboard', compact(
                            'totalRoom',
                            'jumlahGuest',
                            'jumlahReservasi',
                            'jumlahCancel',
                            'jumlahReschedule',
                            'totalTransaksi'
                        )),
            'owner'  => view('owner.dashboard', compact(
                            'totalRoom',
                            'jumlahGuest',
                            'jumlahReservasi',
                            'jumlahCancel',
                            'jumlahReschedule',
                            'totalTransaksi'
                        )),
            'guest'  => view('guest.dashboard'),
            default  => abort(403),
        };
    }
}
