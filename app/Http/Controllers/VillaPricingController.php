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
    public function index()
    {
        $pricings = VillaPricing::with(['villa', 'season'])
            ->orderBy('villa_id')
            ->orderBy('season_id')
            ->paginate(15);

        return view('villa-pricing.index', compact('pricings'));
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
            'special_price' => 'nullable|numeric|min:0',
            'use_special_price' => 'boolean',
            'special_price_description' => 'nullable|string|max:255',
            'range_date_price' => 'nullable|array',
            'range_date_price.*.start_date' => 'nullable|date',
            'range_date_price.*.end_date' => 'nullable|date|after_or_equal:range_date_price.*.start_date',
            'range_date_price.*.price' => 'nullable|numeric|min:0',
            'special_price_range' => 'nullable|array',
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

        $data = $request->all();
        $data['use_special_price'] = $request->has('use_special_price');

        // Clean up range_date_price array
        if ($request->has('range_date_price')) {
            $data['range_date_price'] = array_filter($request->range_date_price, function($item) {
                return !empty($item['start_date']) && !empty($item['end_date']) && !empty($item['price']);
            });
        }

        VillaPricing::create($data);

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
            'special_price' => 'nullable|numeric|min:0',
            'use_special_price' => 'boolean',
            'special_price_description' => 'nullable|string|max:255',
            'range_date_price' => 'nullable|array',
            'range_date_price.*.start_date' => 'nullable|date',
            'range_date_price.*.end_date' => 'nullable|date|after_or_equal:range_date_price.*.start_date',
            'range_date_price.*.price' => 'nullable|numeric|min:0',
            'special_price_range' => 'nullable|array',
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

        $data = $request->all();
        $data['use_special_price'] = $request->has('use_special_price');

        // Clean up range_date_price array
        if ($request->has('range_date_price')) {
            $data['range_date_price'] = array_filter($request->range_date_price, function($item) {
                return !empty($item['start_date']) && !empty($item['end_date']) && !empty($item['price']);
            });
        }

        $villaPricing->update($data);

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
}
