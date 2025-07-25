<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Guest;
use App\Models\Villa;
use App\Models\CekKetersediaan;
use App\Models\VillaPricing;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi.
     */
    public function index()
    {
        $reservasis = Reservasi::with(['guest', 'villa', 'pembayaran'])
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('reservasi.index', compact('reservasis'));
    }

    /**
     * Tampilkan form pembuatan reservasi baru.
     */
    public function create()
    {
        $guests            = Guest::all();
        $villas            = Villa::all();
        $villaPricings     = VillaPricing::all();

        return view('reservasi.create', compact(
            'guests', 'villas',  'villaPricings'
        ));
    }

    /**
     * Simpan reservasi baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_id'             => 'required|exists:tbl_guest,id_guest',
            'villa_id'             => 'required|exists:tbl_villa,id_villa',
            'villa_pricing_id'     => 'required|exists:tbl_villa_pricing,id_villa_pricing',
            'start_date'           => 'required|date',
            'end_date'             => 'required|date|after_or_equal:start_date',
            'status'               => 'required|string|max:50',
            'total_amount'         => 'required|numeric',
        ]);

        Reservasi::create($validated);

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu reservasi.
     */
    public function show(Reservasi $reservasi)
    {
        return view('reservasi.show', compact('reservasi'));
    }

    /**
     * Tampilkan form edit reservasi.
     */
    public function edit(Reservasi $reservasi)
    {
        $guests            = Guest::all();
        $villas            = Villa::all();
        $cekKetersediaans  = CekKetersediaan::all();
        $villaPricings     = VillaPricing::all();

        return view('reservasi.edit', compact(
            'reservasi', 'guests', 'villas', 'cekKetersediaans', 'villaPricings'
        ));
    }

    /**
     * Update data reservasi.
     */
    public function update(Request $request, Reservasi $reservasi)
    {
        $validated = $request->validate([
            'guest_id'             => 'required|exists:tbl_guest,id_guest',
            'villa_id'             => 'required|exists:tbl_villa,id_villa',

            'villa_pricing_id'     => 'required|exists:tbl_villa_pricing,id_villa_pricing',
            'start_date'           => 'required|date',
            'end_date'             => 'required|date|after_or_equal:start_date',
            'status'               => 'required|string|max:50',
            'total_amount'         => 'required|numeric',
        ]);

        $reservasi->update($validated);

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Reservasi berhasil diupdate.');
    }

    /**
     * Hapus reservasi.
     */
    public function destroy(Reservasi $reservasi)
    {
        $reservasi->delete();

        return redirect()
            ->route('reservasi.index')
            ->with('success', 'Reservasi berhasil dihapus.');
    }

    public function checkin(Reservasi $reservasi)
    {
        dd($reservasi);
        // Hanya reservasi dengan status confirmed yang bisa di-checkin
      if (!in_array($reservasi->status, ['confirmed', 'resheduled'])) {
    return back()->with('error', 'Hanya reservasi dengan status confirmed atau resheduled yang bisa di-checkin.');
}

        // Pastikan status check-in masih pending
        if ($reservasi->status_check_in !== 'pending') {
            return back()->with('error', 'Reservasi ini tidak dalam status pending check-in.');
        }

        // Pastikan tanggal check-in sudah tiba
        if (Carbon::now()->toDateString() < $reservasi->start_date) {
            return back()->with('error', 'Belum waktunya check-in untuk reservasi ini.');
        }

        $reservasi->update([
            'status_check_in' => 'checked_in',
            'tanggal_check_in_aktual' => Carbon::now(),
        ]);

        return back()->with('success', 'Tamu berhasil check-in.');
    }

    public function checkout(Reservasi $reservasi)
    {
        // Hanya reservasi dengan status confirmed yang bisa di-checkout
        if ($reservasi->status !== 'confirmed') {
            return back()->with('error', 'Hanya reservasi dengan status confirmed yang bisa di-checkout.');
        }

        // Pastikan status check-in adalah checked_in
        if ($reservasi->status_check_in !== 'checked_in') {
            return back()->with('error', 'Tamu belum check-in, tidak bisa melakukan check-out.');
        }

        $reservasi->update([
            'status_check_in' => 'checked_out',
            'tanggal_check_out_aktual' => Carbon::now(),
        ]);

        return back()->with('success', 'Tamu berhasil check-out.');
    }
}
