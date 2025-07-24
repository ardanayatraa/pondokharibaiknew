<?php

namespace App\Http\Controllers;

use App\Models\VillaPricing;
use App\Models\Villa;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class VillaPricingController extends Controller
{
    /**
     * Display a listing of villa pricing.
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

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('villa', function($q) use ($search) {
                $q->where('nama_villa', 'like', "%{$search}%");
            })->orWhereHas('season', function($q) use ($search) {
                $q->where('nama_season', 'like', "%{$search}%");
            });
        }

        $villaPricings = $query->orderBy('villa_id')
                             ->orderBy('season_id')
                             ->paginate(15)
                             ->withQueryString();

        $villas = Villa::orderBy('nama_villa')->get();
        $seasons = Season::orderBy('priority')->get();

        return view('villa-pricing.index', compact('villaPricings', 'villas', 'seasons'));
    }

    /**
     * Show the form for creating a new villa pricing.
     */
    public function create()
    {
        $villas = Villa::orderBy('nama_villa')->get();
        $seasons = Season::orderBy('priority')->get();

        return view('villa-pricing.create', compact('villas', 'seasons'));
    }

    /**
     * Store a newly created villa pricing in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'villa_id' => ['required', 'exists:tbl_villa,id_villa'],
            'season_id' => ['required', 'exists:tbl_season,id_season'],
            'sunday_pricing' => ['nullable', 'numeric', 'min:0'],
            'monday_pricing' => ['nullable', 'numeric', 'min:0'],
            'tuesday_pricing' => ['nullable', 'numeric', 'min:0'],
            'wednesday_pricing' => ['nullable', 'numeric', 'min:0'],
            'thursday_pricing' => ['nullable', 'numeric', 'min:0'],
            'friday_pricing' => ['nullable', 'numeric', 'min:0'],
            'saturday_pricing' => ['nullable', 'numeric', 'min:0'],
            'special_price' => ['nullable', 'numeric', 'min:0'],
            'use_special_price' => ['boolean'],
            'special_price_description' => ['nullable', 'string', 'max:255'],

            // Range date price validation
            'range_date_prices' => ['nullable', 'array'],
            'range_date_prices.*.start_date' => ['required_with:range_date_prices', 'date'],
            'range_date_prices.*.end_date' => ['required_with:range_date_prices', 'date', 'after_or_equal:range_date_prices.*.start_date'],
            'range_date_prices.*.price' => ['required_with:range_date_prices', 'numeric', 'min:0'],
            'range_date_prices.*.description' => ['nullable', 'string', 'max:255'],

            // Special price range validation
            'special_price_ranges' => ['nullable', 'array'],
            'special_price_ranges.*.start_date' => ['required_with:special_price_ranges', 'date'],
            'special_price_ranges.*.end_date' => ['required_with:special_price_ranges', 'date', 'after_or_equal:special_price_ranges.*.start_date'],
            'special_price_ranges.*.price' => ['required_with:special_price_ranges', 'numeric', 'min:0'],
            'special_price_ranges.*.description' => ['nullable', 'string', 'max:255'],
        ]);

        // Check if combination already exists
        $exists = VillaPricing::where('villa_id', $validated['villa_id'])
                            ->where('season_id', $validated['season_id'])
                            ->exists();

        if ($exists) {
            return back()->withErrors(['villa_id' => 'Pricing untuk villa dan season ini sudah ada.'])
                        ->withInput();
        }

        DB::beginTransaction();
        try {
            // Create basic pricing
            $villaPricing = VillaPricing::create([
                'villa_id' => $validated['villa_id'],
                'season_id' => $validated['season_id'],
                'sunday_pricing' => $validated['sunday_pricing'] ?? 0,
                'monday_pricing' => $validated['monday_pricing'] ?? 0,
                'tuesday_pricing' => $validated['tuesday_pricing'] ?? 0,
                'wednesday_pricing' => $validated['wednesday_pricing'] ?? 0,
                'thursday_pricing' => $validated['thursday_pricing'] ?? 0,
                'friday_pricing' => $validated['friday_pricing'] ?? 0,
                'saturday_pricing' => $validated['saturday_pricing'] ?? 0,
                'special_price' => $validated['special_price'] ?? 0,
                'use_special_price' => $validated['use_special_price'] ?? false,
                'special_price_description' => $validated['special_price_description'],
            ]);

            // Add range date prices
            if (!empty($validated['range_date_prices'])) {
                foreach ($validated['range_date_prices'] as $rangeData) {
                    $villaPricing->addRangeDatePrice($rangeData);
                }
                $villaPricing->save();
            }

            // Add special price ranges
            if (!empty($validated['special_price_ranges'])) {
                foreach ($validated['special_price_ranges'] as $rangeData) {
                    $villaPricing->addSpecialPriceRange($rangeData);
                }
                $villaPricing->save();
            }

            DB::commit();

            return redirect()->route('villa-pricing.index')
                           ->with('success', 'Villa pricing berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    /**
     * Display the specified villa pricing.
     */
    public function show(VillaPricing $villaPricing)
    {
        $villaPricing->load(['villa', 'season']);

        // Get special dates for calendar display
        $specialDates = $villaPricing->getSpecialDates();

        // Check for range conflicts
        $hasConflicts = $villaPricing->hasRangeConflicts();
        $conflicts = $hasConflicts ? $villaPricing->getRangeConflicts() : [];

        return view('villa-pricing.show', compact('villaPricing', 'specialDates', 'hasConflicts', 'conflicts'));
    }

    /**
     * Show the form for editing the specified villa pricing.
     */
    public function edit(VillaPricing $villaPricing)
    {
        $villaPricing->load(['villa', 'season']);
        $villas = Villa::orderBy('nama_villa')->get();
        $seasons = Season::orderBy('priority')->get();

        // Get existing range data
        $rangeDatePrices = $villaPricing->getAllRangeDatePrices();
        $specialPriceRanges = $villaPricing->getAllSpecialPriceRanges();

        return view('villa-pricing.edit', compact(
            'villaPricing',
            'villas',
            'seasons',
            'rangeDatePrices',
            'specialPriceRanges'
        ));
    }

    /**
     * Update the specified villa pricing in storage.
     */
    public function update(Request $request, VillaPricing $villaPricing)
    {
        $validated = $request->validate([
            'villa_id' => ['required', 'exists:tbl_villa,id_villa'],
            'season_id' => ['required', 'exists:tbl_season,id_season'],
            'sunday_pricing' => ['nullable', 'numeric', 'min:0'],
            'monday_pricing' => ['nullable', 'numeric', 'min:0'],
            'tuesday_pricing' => ['nullable', 'numeric', 'min:0'],
            'wednesday_pricing' => ['nullable', 'numeric', 'min:0'],
            'thursday_pricing' => ['nullable', 'numeric', 'min:0'],
            'friday_pricing' => ['nullable', 'numeric', 'min:0'],
            'saturday_pricing' => ['nullable', 'numeric', 'min:0'],
            'special_price' => ['nullable', 'numeric', 'min:0'],
            'use_special_price' => ['boolean'],
            'special_price_description' => ['nullable', 'string', 'max:255'],

            // Range date price validation
            'range_date_prices' => ['nullable', 'array'],
            'range_date_prices.*.start_date' => ['required_with:range_date_prices', 'date'],
            'range_date_prices.*.end_date' => ['required_with:range_date_prices', 'date', 'after_or_equal:range_date_prices.*.start_date'],
            'range_date_prices.*.price' => ['required_with:range_date_prices', 'numeric', 'min:0'],
            'range_date_prices.*.description' => ['nullable', 'string', 'max:255'],

            // Special price range validation
            'special_price_ranges' => ['nullable', 'array'],
            'special_price_ranges.*.start_date' => ['required_with:special_price_ranges', 'date'],
            'special_price_ranges.*.end_date' => ['required_with:special_price_ranges', 'date', 'after_or_equal:special_price_ranges.*.start_date'],
            'special_price_ranges.*.price' => ['required_with:special_price_ranges', 'numeric', 'min:0'],
            'special_price_ranges.*.description' => ['nullable', 'string', 'max:255'],
        ]);

        // Check if combination already exists (excluding current record)
        $exists = VillaPricing::where('villa_id', $validated['villa_id'])
                            ->where('season_id', $validated['season_id'])
                            ->where('id_villa_pricing', '!=', $villaPricing->id_villa_pricing)
                            ->exists();

        if ($exists) {
            return back()->withErrors(['villa_id' => 'Pricing untuk villa dan season ini sudah ada.'])
                        ->withInput();
        }

        DB::beginTransaction();
        try {
            // Update basic pricing
            $villaPricing->update([
                'villa_id' => $validated['villa_id'],
                'season_id' => $validated['season_id'],
                'sunday_pricing' => $validated['sunday_pricing'] ?? 0,
                'monday_pricing' => $validated['monday_pricing'] ?? 0,
                'tuesday_pricing' => $validated['tuesday_pricing'] ?? 0,
                'wednesday_pricing' => $validated['wednesday_pricing'] ?? 0,
                'thursday_pricing' => $validated['thursday_pricing'] ?? 0,
                'friday_pricing' => $validated['friday_pricing'] ?? 0,
                'saturday_pricing' => $validated['saturday_pricing'] ?? 0,
                'special_price' => $validated['special_price'] ?? 0,
                'use_special_price' => $validated['use_special_price'] ?? false,
                'special_price_description' => $validated['special_price_description'],
            ]);

            // Reset range arrays
            $villaPricing->range_date_price = null;
            $villaPricing->special_price_range = null;
            $villaPricing->save();

            // Add new range date prices
            if (!empty($validated['range_date_prices'])) {
                foreach ($validated['range_date_prices'] as $rangeData) {
                    $villaPricing->addRangeDatePrice($rangeData);
                }
                $villaPricing->save();
            }

            // Add new special price ranges
            if (!empty($validated['special_price_ranges'])) {
                foreach ($validated['special_price_ranges'] as $rangeData) {
                    $villaPricing->addSpecialPriceRange($rangeData);
                }
                $villaPricing->save();
            }

            DB::commit();

            return redirect()->route('villa-pricing.index')
                           ->with('success', 'Villa pricing berhasil diupdate.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])
                        ->withInput();
        }
    }

    /**
     * Remove the specified villa pricing from storage.
     */
    public function destroy(VillaPricing $villaPricing)
    {
        try {
            $villaPricing->delete();
            return redirect()->route('villa-pricing.index')
                           ->with('success', 'Villa pricing berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus villa pricing: ' . $e->getMessage()]);
        }
    }

    /**
     * Get pricing for a specific date - AJAX endpoint
     */
    public function getPriceForDate(Request $request, VillaPricing $villaPricing)
    {
        $request->validate([
            'date' => 'required|date'
        ]);

        $priceData = $villaPricing->getPriceForDate($request->date);

        return response()->json([
            'success' => true,
            'data' => $priceData
        ]);
    }

    /**
     * Get pricing summary for date range - AJAX endpoint
     */
    public function getPricingSummary(Request $request, VillaPricing $villaPricing)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $summary = $villaPricing->getPricingSummaryForDateRange(
            $request->start_date,
            $request->end_date
        );

        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }

    /**
     * Clone pricing to another season or villa
     */
    public function clone(Request $request, VillaPricing $villaPricing)
    {
        $validated = $request->validate([
            'target_villa_id' => ['required', 'exists:tbl_villa,id_villa'],
            'target_season_id' => ['required', 'exists:tbl_season,id_season'],
        ]);

        // Check if target combination already exists
        $exists = VillaPricing::where('villa_id', $validated['target_villa_id'])
                            ->where('season_id', $validated['target_season_id'])
                            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Pricing untuk target villa dan season sudah ada.']);
        }

        DB::beginTransaction();
        try {
            // Create new pricing with same data
            $newPricing = $villaPricing->replicate();
            $newPricing->villa_id = $validated['target_villa_id'];
            $newPricing->season_id = $validated['target_season_id'];
            $newPricing->save();

            DB::commit();

            return redirect()->route('villa-pricing.show', $newPricing)
                           ->with('success', 'Villa pricing berhasil di-clone.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Gagal clone pricing: ' . $e->getMessage()]);
        }
    }

    /**
     * Export pricing data to CSV
     */
    public function export(Request $request)
    {
        $query = VillaPricing::with(['villa', 'season']);

        // Apply same filters as index
        if ($request->filled('villa_id')) {
            $query->where('villa_id', $request->villa_id);
        }

        if ($request->filled('season_id')) {
            $query->where('season_id', $request->season_id);
        }

        $pricings = $query->get();

        $filename = 'villa-pricing-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($pricings) {
            $handle = fopen('php://output', 'w');

            // CSV Headers
            fputcsv($handle, [
                'Villa',
                'Season',
                'Sunday',
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
                'Special Price',
                'Use Special Price',
                'Special Price Description'
            ]);

            foreach ($pricings as $pricing) {
                fputcsv($handle, [
                    $pricing->villa->nama_villa ?? '',
                    $pricing->season->nama_season ?? '',
                    $pricing->sunday_pricing,
                    $pricing->monday_pricing,
                    $pricing->tuesday_pricing,
                    $pricing->wednesday_pricing,
                    $pricing->thursday_pricing,
                    $pricing->friday_pricing,
                    $pricing->saturday_pricing,
                    $pricing->special_price,
                    $pricing->use_special_price ? 'Yes' : 'No',
                    $pricing->special_price_description
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
