<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $role = session('role');

        // Tambahan statistik
        $totalTransaksi = Pembayaran::sum('amount');
        $jumlahGuest = Guest::count();

        return match ($role) {
            'admin' => view('dashboard', compact('totalTransaksi', 'jumlahGuest')),
            'owner' => view('owner.dashboard', compact('totalTransaksi', 'jumlahGuest')),
            'guest' => view('guest.dashboard'),
            default => abort(403),
        };
    }
}
