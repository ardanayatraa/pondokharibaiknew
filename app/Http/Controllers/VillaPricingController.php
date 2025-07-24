<?php

namespace App\Http\Controllers;

use App\Models\VillaPricing;
use App\Models\Villa;
use App\Models\Season;
use Illuminate\Http\Request;

class VillaPricingController extends Controller
{
    /**
     * Tampilkan daftar semua VillaPricing.
     */
    public function index()
    {
        $pricings = VillaPricing::with(['villa', 'season'])
                                ->orderBy('villa_id')
                                ->orderBy('season_id')
                                ->get();
        return view('harga-villa.index', compact('pricings'));
    }

    /**
     * Tampilkan form untuk membuat VillaPricing baru.
     */
    public function create()
    {
        $villas   = Villa::all();
        $seasons  = Season::orderBy('tgl_mulai_season', 'desc')->get();
        return view('harga-villa.create', compact('villas', 'seasons'));
    }

    /**
     * Simpan VillaPricing baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'villa_id'                 => 'nullable|exists:tbl_villa,id_villa',
            'season_id'                => 'nullable|exists:tbl_season,id_season',
            'sunday_pricing'           => 'nullable|integer|min:0',
            'monday_pricing'           => 'nullable|integer|min:0',
            'tuesday_pricing'          => 'nullable|integer|min:0',
            'wednesday_pricing'        => 'nullable|integer|min:0',
            'thursday_pricing'         => 'nullable|integer|min:0',
            'friday_pricing'           => 'nullable|integer|min:0',
            'saturday_pricing'         => 'nullable|integer|min:0',
        ]);

        VillaPricing::create($validated);

        return redirect()->route('harga-villa.index')
                         ->with('success', 'VillaPricing berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu VillaPricing.
     */
    public function show($id_villa_pricing)
    {
        $pricing = VillaPricing::with(['villa', 'season'])
                               ->findOrFail($id_villa_pricing);
        return view('harga-villa.show', compact('pricing'));
    }

    /**
     * Tampilkan form edit untuk VillaPricing tertentu.
     */
    public function edit($id_villa_pricing)
    {
        $pricing = VillaPricing::findOrFail($id_villa_pricing);
        $villas  = Villa::all();
        $seasons = Season::orderBy('tgl_mulai_season', 'desc')->get();
        return view('harga-villa.edit', compact('pricing', 'villas', 'seasons'));
    }

    /**
     * Update data VillaPricing yang sudah ada.
     */
    public function update(Request $request, $id_villa_pricing)
    {
        $pricing = VillaPricing::findOrFail($id_villa_pricing);

        $validated = $request->validate([
            'villa_id'                 => 'nullable|exists:tbl_villa,id_villa',
            'season_id'                => 'nullable|exists:tbl_season,id_season',
            'sunday_pricing'           => 'nullable|integer|min:0',
            'monday_pricing'           => 'nullable|integer|min:0',
            'tuesday_pricing'          => 'nullable|integer|min:0',
            'wednesday_pricing'        => 'nullable|integer|min:0',
            'thursday_pricing'         => 'nullable|integer|min:0',
            'friday_pricing'           => 'nullable|integer|min:0',
            'saturday_pricing'         => 'nullable|integer|min:0',
        ]);

        $pricing->update($validated);

        return redirect()->route('harga-villa.index')
                         ->with('success', 'VillaPricing berhasil diperbarui.');
    }

    /**
     * Hapus satu VillaPricing.
     */
    public function destroy($id_villa_pricing)
    {
        $pricing = VillaPricing::findOrFail($id_villa_pricing);
        $pricing->delete();

        return redirect()->route('harga-villa.index')
                         ->with('success', 'VillaPricing berhasil dihapus.');
    }
}
