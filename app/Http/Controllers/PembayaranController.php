<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Tampilkan daftar pembayaran.
     */
    public function index()
    {
        $pembayarans = Pembayaran::with(['guest', 'reservasi'])->paginate(10);
        return view('pembayaran.index', compact('pembayarans'));
    }

    /**
     * Tampilkan form pembuatan pembayaran baru.
     */
    public function create()
    {
        // ambil semua guest dan reservasi
        $guests    = Guest::all();
        $reservasis = Reservasi::with('villa')->get();

        return view('pembayaran.create', compact('guests', 'reservasis'));
    }

    /**
     * Simpan pembayaran baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_id'       => 'required|exists:tbl_guest,id_guest',
            'reservation_id' => 'required|exists:tbl_reservasi,id_reservasi',
            'amount'         => 'required|numeric',
            'payment_date'   => 'required|date',
            'snap_token'     => 'nullable|string',
            'notifikasi'     => 'nullable|string',
            'status'         => 'required|string|max:50',
        ]);

        Pembayaran::create($validated);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu pembayaran.
     */
    public function show(Pembayaran $pembayaran)
    {
        return view('pembayaran.show', compact('pembayaran'));
    }

    /**
     * Tampilkan form edit pembayaran.
     */
    public function edit(Pembayaran $pembayaran)
    {
        // Ambil data Guest dan Reservasi untuk dropdown
        $guests     = Guest::all();
        $reservasis = Reservasi::with('villa')->get();

        return view('pembayaran.edit', compact('pembayaran', 'guests', 'reservasis'));
    }

    /**
     * Update data pembayaran.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $validated = $request->validate([
            'guest_id'       => 'required|exists:tbl_guest,id_guest',
            'reservation_id' => 'required|exists:tbl_reservasi,id_reservasi',
            'amount'         => 'required|numeric',
            'payment_date'   => 'required|date',
            'snap_token'     => 'nullable|string',
            'notifikasi'     => 'nullable|string',
            'status'         => 'required|string|max:50',
        ]);

        $pembayaran->update($validated);

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil diupdate.');
    }

    /**
     * Hapus pembayaran.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dihapus.');
    }
}
