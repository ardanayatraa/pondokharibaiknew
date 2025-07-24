<?php

namespace App\Http\Controllers;

use App\Models\VillaPricing;
use App\Models\Villa;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VillaPricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VillaPricing::with(['villa', 'season']);

        // Filter by villa
        if ($request->filled('villa_id')) {
            $query->where('villa_id', $request->villa_id);
        }

        // Filter by season
        if ($request->filled('season_id')) {
            $query->where('season_id', $request->season_id);
        }

        // Search by villa name
        if ($request->filled('search')) {
            $query->whereHas('villa', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $pricings = $query->orderBy('villa_id')
            ->orderBy('season_id')
            ->paginate(15)
            ->withQueryString();

        $villas = Villa::orderBy('name')->get();
        $seasons = Season::orderBy('nama_season')->get();

        return view('villa-pricing.index', compact('pricings', 'villas', 'seasons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villas = Villa::orderBy('name')->get();
        $seasons = Season::orderBy('nama_season')->get();

        return view('villa-pricing.create', compact('villas', 'seasons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'villa_id' => 'required|exists:tbl_villa,id_villa',
            'season_id' => 'required|exists:tbl_season,id_season',
            'sunday_pricing' => 'nullable|numeric|min:0',
            'monday_pricing' => 'nullable|numeric|min:0',
            'tuesday_pricing' => 'nullable|numeric|min:0',
            'wednesday_pricing' => 'nullable|numeric|min:0',
            'thursday_pricing' => 'nullable|numeric|min:0',
            'friday_pricing' => 'nullable|numeric|min:0',
            'saturday_pricing' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if combination already exists
        $exists = VillaPricing::where('villa_id', $request->villa_id)
            ->where('season_id', $request->season_id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Pricing untuk villa dan season ini sudah ada!')
                ->withInput();
        }

        VillaPricing::create($request->all());

        return redirect()->route('villa-pricing.index')
            ->with('success', 'Villa pricing berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(VillaPricing $villaPricing)
    {
        $villaPricing->load(['villa', 'season']);
        return view('villa-pricing.show', compact('villaPricing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VillaPricing $villaPricing)
    {
        $villas = Villa::orderBy('name')->get();
        $seasons = Season::orderBy('nama_season')->get();

        return view('villa-pricing.edit', compact('villaPricing', 'villas', 'seasons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VillaPricing $villaPricing)
    {
        $validator = Validator::make($request->all(), [
            'villa_id' => 'required|exists:tbl_villa,id_villa',
            'season_id' => 'required|exists:tbl_season,id_season',
            'sunday_pricing' => 'nullable|numeric|min:0',
            'monday_pricing' => 'nullable|numeric|min:0',
            'tuesday_pricing' => 'nullable|numeric|min:0',
            'wednesday_pricing' => 'nullable|numeric|min:0',
            'thursday_pricing' => 'nullable|numeric|min:0',
            'friday_pricing' => 'nullable|numeric|min:0',
            'saturday_pricing' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if combination already exists (excluding current record)
        $exists = VillaPricing::where('villa_id', $request->villa_id)
            ->where('season_id', $request->season_id)
            ->where('id_villa_pricing', '!=', $villaPricing->id_villa_pricing)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Pricing untuk villa dan season ini sudah ada!')
                ->withInput();
        }

        $villaPricing->update($request->all());

        return redirect()->route('villa-pricing.index')
            ->with('success', 'Villa pricing berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VillaPricing $villaPricing)
    {
        $villaPricing->delete();

        return redirect()->route('villa-pricing.index')
            ->with('success', 'Villa pricing berhasil dihapus!');
    }

    /**
     * Bulk delete selected villa pricings
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected_ids' => 'required|array',
            'selected_ids.*' => 'exists:tbl_villa_pricing,id_villa_pricing'
        ]);

        $count = VillaPricing::whereIn('id_villa_pricing', $request->selected_ids)->delete();

        return redirect()->route('villa-pricing.index')
            ->with('success', "Berhasil menghapus {$count} villa pricing!");
    }

    /**
     * Copy pricing from one season to another
     */
    public function copyPricing(Request $request)
    {
        $request->validate([
            'source_season_id' => 'required|exists:tbl_season,id_season',
            'target_season_id' => 'required|exists:tbl_season,id_season|different:source_season_id',
            'villa_ids' => 'nullable|array',
            'villa_ids.*' => 'exists:tbl_villa,id_villa'
        ]);

        $sourcePricings = VillaPricing::where('season_id', $request->source_season_id);

        if ($request->has('villa_ids') && !empty($request->villa_ids)) {
            $sourcePricings->whereIn('villa_id', $request->villa_ids);
        }

        $sourcePricings = $sourcePricings->get();

        $copiedCount = 0;
        foreach ($sourcePricings as $pricing) {
            // Check if target pricing already exists
            $existingPricing = VillaPricing::where('villa_id', $pricing->villa_id)
                ->where('season_id', $request->target_season_id)
                ->first();

            if (!$existingPricing) {
                VillaPricing::create([
                    'villa_id' => $pricing->villa_id,
                    'season_id' => $request->target_season_id,
                    'sunday_pricing' => $pricing->sunday_pricing,
                    'monday_pricing' => $pricing->monday_pricing,
                    'tuesday_pricing' => $pricing->tuesday_pricing,
                    'wednesday_pricing' => $pricing->wednesday_pricing,
                    'thursday_pricing' => $pricing->thursday_pricing,
                    'friday_pricing' => $pricing->friday_pricing,
                    'saturday_pricing' => $pricing->saturday_pricing,
                ]);
                $copiedCount++;
            }
        }

        return redirect()->route('villa-pricing.index')
            ->with('success', "Berhasil menyalin {$copiedCount} villa pricing ke season baru!");
    }
}
