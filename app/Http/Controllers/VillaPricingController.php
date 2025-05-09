<?php

namespace App\Http\Controllers;

use App\Models\VillaPricing;
use App\Models\Villa;
use App\Models\Season;
use Illuminate\Http\Request;

class VillaPricingController extends Controller
{
    /**
     * Tampilkan daftar villa pricing.
     */
    public function index()
    {
        $pricings = VillaPricing::orderBy('created_at', 'desc')
           ->get();

        return view('harga-villa.index', compact('pricings'));
    }

    /**
     * Tampilkan form pembuatan villa pricing baru.
     */
    public function create()
    {
        $villas  = Villa::all();
        $seasons = Season::orderBy('tgl_mulai_season','desc')->get();

        return view('harga-villa.create', compact('villas', 'seasons'));
    }

    /**
     * Simpan villa pricing baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'villa_id'        => 'required|exists:tbl_villa,id_villa',
            'season_id'       => 'required|exists:tbl_season,id_season',
            'sunday_pricing'  => 'required|numeric',
            'monday_pricing'  => 'required|numeric',
            'tuesday_pricing' => 'required|numeric',
            'wednesday_pricing'=> 'required|numeric',
            'thursday_pricing'=> 'required|numeric',
            'friday_pricing'  => 'required|numeric',
            'saturday_pricing'=> 'required|numeric',
        ]);

        VillaPricing::create($validated);

        return redirect()
            ->route('harga-villa.index')
            ->with('success', 'VillaPricing berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu villa pricing.
     */
    public function show(VillaPricing $villa_pricing)
    {
        return view('harga-villa.show', compact('villa_pricing'));
    }

    /**
     * Tampilkan form edit villa pricing.
     */
    public function edit(VillaPricing $harga_villa)
    {
        $villa_pricing=$harga_villa;
        $villas  = Villa::all();
        $seasons = Season::orderBy('tgl_mulai_season','desc')->get();

        return view('harga-villa.edit', compact('villa_pricing', 'villas', 'seasons'));
    }

    /**
     * Update data villa pricing.
     */
    public function update(Request $request, VillaPricing $harga_villa)
    {
        $villa_pricing=$harga_villa;
        $validated = $request->validate([
            'villa_id'        => 'required|exists:tbl_villa,id_villa',
            'season_id'       => 'required|exists:tbl_season,id_season',
            'sunday_pricing'  => 'required|numeric',
            'monday_pricing'  => 'required|numeric',
            'tuesday_pricing' => 'required|numeric',
            'wednesday_pricing'=> 'required|numeric',
            'thursday_pricing'=> 'required|numeric',
            'friday_pricing'  => 'required|numeric',
            'saturday_pricing'=> 'required|numeric',
        ]);

        $villa_pricing->update($validated);

        return redirect()
            ->route('harga-villa.index')
            ->with('success', 'VillaPricing berhasil diupdate.');
    }

    /**
     * Hapus villa pricing.
     */
    public function destroy(VillaPricing $villa_pricing)
    {
        $villa_pricing->first()->delete();

        return redirect()
            ->route('harga-villa.index')
            ->with('success', 'VillaPricing berhasil dihapus.');
    }
}
