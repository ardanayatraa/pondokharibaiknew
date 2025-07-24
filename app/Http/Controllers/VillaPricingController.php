<?php

namespace App\Http\Controllers;

use App\Models\VillaPricing;
use App\Models\Villa;
use App\Models\Season;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'villa_id'                 => 'required|exists:tbl_villa,id_villa',
            'season_id'                => 'required|exists:tbl_season,id_season',
            'sunday_pricing'           => 'nullable|integer|min:0',
            'monday_pricing'           => 'nullable|integer|min:0',
            'tuesday_pricing'          => 'nullable|integer|min:0',
            'wednesday_pricing'        => 'nullable|integer|min:0',
            'thursday_pricing'         => 'nullable|integer|min:0',
            'friday_pricing'           => 'nullable|integer|min:0',
            'saturday_pricing'         => 'nullable|integer|min:0',
            'special_price'            => 'nullable|integer|min:0',
            'use_special_price'        => 'nullable|boolean',
            'special_price_description' => 'nullable|string|max:255',
            'start_date'               => 'nullable|date',
            'end_date'                 => 'nullable|date|after_or_equal:start_date',
            // New fields for special price range dates
            'use_special_price_for_range' => 'nullable|boolean',
            'special_price_range'      => 'nullable|integer|min:0',
            'special_price_start_date' => 'nullable|date',
            'special_price_end_date'   => 'nullable|date|after_or_equal:special_price_start_date',
            'range_date_prices'        => 'nullable|array',
            'special_price_ranges'     => 'nullable|array',
        ]);

        // Cek apakah sudah ada pricing untuk villa dan season yang sama
        $existingPricing = VillaPricing::where('villa_id', $validated['villa_id'])
                                      ->where('season_id', $validated['season_id'])
                                      ->first();

        if ($existingPricing) {
            return redirect()->back()
                           ->withErrors(['season_id' => 'Pricing untuk villa dan season ini sudah ada.'])
                           ->withInput();
        }

        // Ambil data season
        $season = Season::findOrFail($validated['season_id']);

        // Validasi bahwa harga per hari hanya diisi untuk hari yang ada di days_of_week season
        if ($season->repeat_weekly) {
            $dayMapping = [
                0 => 'sunday_pricing',
                1 => 'monday_pricing',
                2 => 'tuesday_pricing',
                3 => 'wednesday_pricing',
                4 => 'thursday_pricing',
                5 => 'friday_pricing',
                6 => 'saturday_pricing'
            ];

            foreach ($dayMapping as $dayIndex => $pricingField) {
                if (!in_array($dayIndex, $season->days_of_week) && !empty($validated[$pricingField])) {
                    return redirect()->back()
                        ->withErrors([$pricingField => 'Harga untuk hari ini tidak dapat diisi karena tidak termasuk dalam days_of_week season.'])
                        ->withInput();
                }
            }
        }

        // Handle range_date_price (untuk override harga reguler pada tanggal tertentu)
        $rangeDatePrices = [];

        // Jika ada range_date_prices[] dari form
        if ($request->has('range_date_prices') && is_array($request->range_date_prices)) {
            foreach ($request->range_date_prices as $rangeDatePriceJson) {
                $rangeDatePriceData = json_decode($rangeDatePriceJson, true);

                if (isset($rangeDatePriceData['start_date']) && isset($rangeDatePriceData['end_date']) && isset($rangeDatePriceData['price'])) {
                    $startDate = Carbon::parse($rangeDatePriceData['start_date']);
                    $endDate = Carbon::parse($rangeDatePriceData['end_date']);

                    // Validasi range tanggal sesuai dengan season
                    if (!$season->repeat_weekly) {
                        // Jika season tidak repeat_weekly, pastikan range tanggal berada dalam range tanggal season
                        if ($startDate->lt($season->tgl_mulai_season) || $endDate->gt($season->tgl_akhir_season)) {
                            return redirect()->back()
                                ->withErrors(['range_date_price' => 'Range tanggal harus berada dalam range tanggal season.'])
                                ->withInput();
                        }
                    }

                    $dates = [];
                    $currentDate = $startDate->copy();
                    while ($currentDate->lte($endDate)) {
                        // Jika season repeat_weekly, pastikan hanya hari yang ada di days_of_week yang digunakan
                        if ($season->repeat_weekly && !in_array($currentDate->dayOfWeek, $season->days_of_week)) {
                            $currentDate->addDay();
                            continue;
                        }

                        $dates[] = $currentDate->format('Y-m-d');
                        $currentDate->addDay();
                    }

                    // Jika tidak ada tanggal yang valid, skip
                    if (empty($dates)) {
                        continue;
                    }

                    $rangeDatePrices[] = [
                        'start_date' => $rangeDatePriceData['start_date'],
                        'end_date' => $rangeDatePriceData['end_date'],
                        'dates' => $dates,
                        'price' => $rangeDatePriceData['price'],
                        'description' => $rangeDatePriceData['description'] ?? 'Harga khusus untuk periode tertentu'
                    ];
                }
            }
        }

        // Jika ada input langsung dari form
        if (!empty($validated['start_date']) && !empty($validated['end_date']) && !empty($validated['range_date_price_value'])) {
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);

            // Validasi range tanggal sesuai dengan season
            if (!$season->repeat_weekly) {
                // Jika season tidak repeat_weekly, pastikan range tanggal berada dalam range tanggal season
                if ($startDate->lt($season->tgl_mulai_season) || $endDate->gt($season->tgl_akhir_season)) {
                    return redirect()->back()
                        ->withErrors(['range_date_price' => 'Range tanggal harus berada dalam range tanggal season.'])
                        ->withInput();
                }
            }

            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                // Jika season repeat_weekly, pastikan hanya hari yang ada di days_of_week yang digunakan
                if ($season->repeat_weekly && !in_array($currentDate->dayOfWeek, $season->days_of_week)) {
                    $currentDate->addDay();
                    continue;
                }

                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            // Jika tidak ada tanggal yang valid, skip
            if (!empty($dates)) {
                $rangeDatePrices[] = [
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'dates' => $dates,
                    'price' => $validated['range_date_price_value'],
                    'description' => $validated['special_price_description'] ?? 'Harga khusus untuk periode tertentu'
                ];
            }
        }

        // Handle special_price_range (untuk special price pada tanggal tertentu)
        $specialPriceRanges = [];

        // Jika ada special_price_ranges[] dari form
        if ($request->has('special_price_ranges') && is_array($request->special_price_ranges)) {
            foreach ($request->special_price_ranges as $specialPriceRangeJson) {
                $specialPriceRangeData = json_decode($specialPriceRangeJson, true);

                if (isset($specialPriceRangeData['start_date']) && isset($specialPriceRangeData['end_date']) && isset($specialPriceRangeData['price'])) {
                    $startDate = Carbon::parse($specialPriceRangeData['start_date']);
                    $endDate = Carbon::parse($specialPriceRangeData['end_date']);

                    // Validasi range tanggal sesuai dengan season
                    if (!$season->repeat_weekly) {
                        // Jika season tidak repeat_weekly, pastikan range tanggal berada dalam range tanggal season
                        if ($startDate->lt($season->tgl_mulai_season) || $endDate->gt($season->tgl_akhir_season)) {
                            return redirect()->back()
                                ->withErrors(['special_price_range' => 'Range tanggal harus berada dalam range tanggal season.'])
                                ->withInput();
                        }
                    }

                    $dates = [];
                    $currentDate = $startDate->copy();
                    while ($currentDate->lte($endDate)) {
                        // Jika season repeat_weekly, pastikan hanya hari yang ada di days_of_week yang digunakan
                        if ($season->repeat_weekly && !in_array($currentDate->dayOfWeek, $season->days_of_week)) {
                            $currentDate->addDay();
                            continue;
                        }

                        $dates[] = $currentDate->format('Y-m-d');
                        $currentDate->addDay();
                    }

                    // Jika tidak ada tanggal yang valid, skip
                    if (empty($dates)) {
                        continue;
                    }

                    $specialPriceRanges[] = [
                        'start_date' => $specialPriceRangeData['start_date'],
                        'end_date' => $specialPriceRangeData['end_date'],
                        'dates' => $dates,
                        'price' => $specialPriceRangeData['price'],
                        'description' => $specialPriceRangeData['description'] ?? 'Special price untuk tanggal tertentu'
                    ];
                }
            }
        }

        // Jika ada input langsung dari form
        if (!empty($validated['special_price_start_date']) &&
            !empty($validated['special_price_end_date']) &&
            !empty($validated['special_price_range']) &&
            $validated['use_special_price_for_range']) {

            $spStartDate = Carbon::parse($validated['special_price_start_date']);
            $spEndDate = Carbon::parse($validated['special_price_end_date']);

            // Validasi range tanggal sesuai dengan season
            if (!$season->repeat_weekly) {
                // Jika season tidak repeat_weekly, pastikan range tanggal berada dalam range tanggal season
                if ($spStartDate->lt($season->tgl_mulai_season) || $spEndDate->gt($season->tgl_akhir_season)) {
                    return redirect()->back()
                        ->withErrors(['special_price_range' => 'Range tanggal harus berada dalam range tanggal season.'])
                        ->withInput();
                }
            }

            $spDates = [];
            $currentDate = $spStartDate->copy();
            while ($currentDate->lte($spEndDate)) {
                // Jika season repeat_weekly, pastikan hanya hari yang ada di days_of_week yang digunakan
                if ($season->repeat_weekly && !in_array($currentDate->dayOfWeek, $season->days_of_week)) {
                    $currentDate->addDay();
                    continue;
                }

                $spDates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            // Jika tidak ada tanggal yang valid, skip
            if (!empty($spDates)) {
                $specialPriceRanges[] = [
                    'start_date' => $validated['special_price_start_date'],
                    'end_date' => $validated['special_price_end_date'],
                    'dates' => $spDates,
                    'price' => $validated['special_price_range'],
                    'description' => $validated['special_price_description'] ?? 'Special price untuk tanggal tertentu'
                ];
            }
        }

        // Remove fields yang tidak ada di model
        unset($validated['start_date'], $validated['end_date']);
        unset($validated['use_special_price_for_range'], $validated['special_price_range']);
        unset($validated['special_price_start_date'], $validated['special_price_end_date']);
        unset($validated['range_date_prices'], $validated['special_price_ranges']);
        unset($validated['range_date_price_value']);

        // Add arrays to validated data
        if (!empty($rangeDatePrices)) {
            $validated['range_date_price'] = count($rangeDatePrices) === 1 ? $rangeDatePrices[0] : $rangeDatePrices;
        }

        if (!empty($specialPriceRanges)) {
            $validated['special_price_range'] = count($specialPriceRanges) === 1 ? $specialPriceRanges[0] : $specialPriceRanges;
        }

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
            'villa_id'                 => 'required|exists:tbl_villa,id_villa',
            'season_id'                => 'required|exists:tbl_season,id_season',
            'sunday_pricing'           => 'nullable|integer|min:0',
            'monday_pricing'           => 'nullable|integer|min:0',
            'tuesday_pricing'          => 'nullable|integer|min:0',
            'wednesday_pricing'        => 'nullable|integer|min:0',
            'thursday_pricing'         => 'nullable|integer|min:0',
            'friday_pricing'           => 'nullable|integer|min:0',
            'saturday_pricing'         => 'nullable|integer|min:0',
            'special_price'            => 'nullable|integer|min:0',
            'use_special_price'        => 'nullable|boolean',
            'special_price_description' => 'nullable|string|max:255',
            'start_date'               => 'nullable|date',
            'end_date'                 => 'nullable|date|after_or_equal:start_date',
            // New fields for special price range dates
            'use_special_price_for_range' => 'nullable|boolean',
            'special_price_range'      => 'nullable|integer|min:0',
            'special_price_start_date' => 'nullable|date',
            'special_price_end_date'   => 'nullable|date|after_or_equal:special_price_start_date',
            'range_date_prices'        => 'nullable|array',
            'special_price_ranges'     => 'nullable|array',
        ]);

        // Cek apakah ada pricing lain dengan villa dan season yang sama (kecuali yang sedang di-edit)
        $existingPricing = VillaPricing::where('villa_id', $validated['villa_id'])
                                      ->where('season_id', $validated['season_id'])
                                      ->where('id_villa_pricing', '!=', $id_villa_pricing)
                                      ->first();

        if ($existingPricing) {
            return redirect()->back()
                           ->withErrors(['season_id' => 'Pricing untuk villa dan season ini sudah ada.'])
                           ->withInput();
        }

        // Ambil data season
        $season = Season::findOrFail($validated['season_id']);

        // Validasi bahwa harga per hari hanya diisi untuk hari yang ada di days_of_week season
        if ($season->repeat_weekly) {
            $dayMapping = [
                0 => 'sunday_pricing',
                1 => 'monday_pricing',
                2 => 'tuesday_pricing',
                3 => 'wednesday_pricing',
                4 => 'thursday_pricing',
                5 => 'friday_pricing',
                6 => 'saturday_pricing'
            ];

            foreach ($dayMapping as $dayIndex => $pricingField) {
                if (!in_array($dayIndex, $season->days_of_week) && !empty($validated[$pricingField])) {
                    return redirect()->back()
                        ->withErrors([$pricingField => 'Harga untuk hari ini tidak dapat diisi karena tidak termasuk dalam days_of_week season.'])
                        ->withInput();
                }
            }
        }

        // Get existing range_date_price and special_price_range
        $existingRangeDatePrices = [];
        if ($pricing->range_date_price) {
            if (isset($pricing->range_date_price['dates'])) {
                // Single object format
                $existingRangeDatePrices = [$pricing->range_date_price];
            } else {
                // Array of objects format
                $existingRangeDatePrices = $pricing->range_date_price;
            }
        }

        $existingSpecialPriceRanges = [];
        if ($pricing->special_price_range) {
            if (isset($pricing->special_price_range['dates'])) {
                // Single object format
                $existingSpecialPriceRanges = [$pricing->special_price_range];
            } else {
                // Array of objects format
                $existingSpecialPriceRanges = $pricing->special_price_range;
            }
        }

        // Handle range_date_price (untuk override harga reguler pada tanggal tertentu)
        if (!empty($validated['start_date']) && !empty($validated['end_date']) && !empty($validated['range_date_price_value'])) {
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);

            // Validasi range tanggal sesuai dengan season
            if (!$season->repeat_weekly) {
                // Jika season tidak repeat_weekly, pastikan range tanggal berada dalam range tanggal season
                if ($startDate->lt($season->tgl_mulai_season) || $endDate->gt($season->tgl_akhir_season)) {
                    return redirect()->back()
                        ->withErrors(['range_date_price' => 'Range tanggal harus berada dalam range tanggal season.'])
                        ->withInput();
                }
            }

            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                // Jika season repeat_weekly, pastikan hanya hari yang ada di days_of_week yang digunakan
                if ($season->repeat_weekly && !in_array($currentDate->dayOfWeek, $season->days_of_week)) {
                    $currentDate->addDay();
                    continue;
                }

                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            // Jika tidak ada tanggal yang valid, skip
            if (!empty($dates)) {
                $rangeDatePrice = [
                    'start_date' => $validated['start_date'],
                    'end_date' => $validated['end_date'],
                    'dates' => $dates,
                    'price' => $validated['range_date_price_value'],
                    'description' => $validated['special_price_description'] ?? 'Harga khusus untuk periode tertentu'
                ];

                // Tambahkan ke array yang sudah ada
                $existingRangeDatePrices[] = $rangeDatePrice;
            }
        }

        // Handle special_price_range (untuk special price pada tanggal tertentu)
        if (!empty($validated['special_price_start_date']) &&
            !empty($validated['special_price_end_date']) &&
            !empty($validated['special_price_range']) &&
            $validated['use_special_price_for_range']) {

            $spStartDate = Carbon::parse($validated['special_price_start_date']);
            $spEndDate = Carbon::parse($validated['special_price_end_date']);

            // Validasi range tanggal sesuai dengan season
            if (!$season->repeat_weekly) {
                // Jika season tidak repeat_weekly, pastikan range tanggal berada dalam range tanggal season
                if ($spStartDate->lt($season->tgl_mulai_season) || $spEndDate->gt($season->tgl_akhir_season)) {
                    return redirect()->back()
                        ->withErrors(['special_price_range' => 'Range tanggal harus berada dalam range tanggal season.'])
                        ->withInput();
                }
            }

            $spDates = [];
            $currentDate = $spStartDate->copy();
            while ($currentDate->lte($spEndDate)) {
                // Jika season repeat_weekly, pastikan hanya hari yang ada di days_of_week yang digunakan
                if ($season->repeat_weekly && !in_array($currentDate->dayOfWeek, $season->days_of_week)) {
                    $currentDate->addDay();
                    continue;
                }

                $spDates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            // Jika tidak ada tanggal yang valid, skip
            if (!empty($spDates)) {
                $specialPriceRange = [
                    'start_date' => $validated['special_price_start_date'],
                    'end_date' => $validated['special_price_end_date'],
                    'dates' => $spDates,
                    'price' => $validated['special_price_range'],
                    'description' => $validated['special_price_description'] ?? 'Special price untuk tanggal tertentu'
                ];

                // Tambahkan ke array yang sudah ada
                $existingSpecialPriceRanges[] = $specialPriceRange;
            }
        }

        // Remove fields yang tidak ada di model
        unset($validated['start_date'], $validated['end_date']);
        unset($validated['use_special_price_for_range'], $validated['special_price_range']);
        unset($validated['special_price_start_date'], $validated['special_price_end_date']);
        unset($validated['range_date_prices'], $validated['special_price_ranges']);
        unset($validated['range_date_price_value']);

        // Add arrays to validated data
        if (!empty($existingRangeDatePrices)) {
            $validated['range_date_price'] = count($existingRangeDatePrices) === 1 ? $existingRangeDatePrices[0] : $existingRangeDatePrices;
        }

        if (!empty($existingSpecialPriceRanges)) {
            $validated['special_price_range'] = count($existingSpecialPriceRanges) === 1 ? $existingSpecialPriceRanges[0] : $existingSpecialPriceRanges;
        }

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

    /**
     * Get pricing for a specific villa on a specific date
     */
    public function getPricingByDate($villa_id, $date)
    {
        try {
            $targetDate = Carbon::parse($date);
            $dayOfWeek = $targetDate->dayOfWeek;
            $dateString = $targetDate->format('Y-m-d');

            // Cari season yang aktif pada tanggal tersebut
            $activeSeason = Season::where('tgl_mulai_season', '<=', $targetDate)
                                  ->where('tgl_selesai_season', '>=', $targetDate)
                                  ->first();

            if (!$activeSeason) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada season aktif untuk tanggal ini'
                ], 404);
            }

            // Cek apakah hari ini termasuk dalam days_of_week season
            if (!in_array($dayOfWeek, $activeSeason->days_of_week)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Villa tidak tersedia pada hari ini sesuai season'
                ], 404);
            }

            // Cari pricing untuk villa dan season tersebut
            $pricing = VillaPricing::where('villa_id', $villa_id)
                                  ->where('season_id', $activeSeason->id_season)
                                  ->first();

            if (!$pricing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pricing tidak ditemukan untuk villa dan season ini'
                ], 404);
            }

            // PRIORITAS PRICING:
            // 1. Special Price Range (jika tanggal ada dalam special_price_range)
            // 2. Range Date Price (jika tanggal ada dalam range_date_price)
            // 3. Global Special Price (jika use_special_price = true)
            // 4. Harga per hari sesuai day of week

            $price = null;
            $pricingSource = null;
            $description = null;

            // 1. Cek Special Price Range terlebih dahulu
            $specialPriceRange = $pricing->getSpecialPriceRangeForDate($dateString);
            if ($specialPriceRange && isset($specialPriceRange['price']) && $specialPriceRange['price'] > 0) {
                $price = $specialPriceRange['price'];
                $pricingSource = 'special_price_range';
                $description = $specialPriceRange['description'] ?? 'Special price untuk tanggal tertentu';
            }
            // 2. Cek Range Date Price
            else {
                $rangeDatePrice = $pricing->getRangeDatePriceForDate($dateString);
                if ($rangeDatePrice && isset($rangeDatePrice['price']) && $rangeDatePrice['price'] > 0) {
                    $price = $rangeDatePrice['price'];
                    $pricingSource = 'range_date_price';
                    $description = $rangeDatePrice['description'] ?? 'Harga khusus untuk periode tertentu';
                }
                // 3. Cek Global Special Price
                else if ($pricing->use_special_price && $pricing->special_price > 0) {
                    $price = $pricing->special_price;
                    $pricingSource = 'global_special_price';
                    $description = $pricing->special_price_description ?? 'Special price';
                }
                // 4. Gunakan harga per hari
                else {
                    $dayMapping = [
                        0 => 'sunday_pricing',
                        1 => 'monday_pricing',
                        2 => 'tuesday_pricing',
                        3 => 'wednesday_pricing',
                        4 => 'thursday_pricing',
                        5 => 'friday_pricing',
                        6 => 'saturday_pricing'
                    ];

                    $pricingField = $dayMapping[$dayOfWeek];
                    $price = $pricing->$pricingField;
                    $pricingSource = 'day_of_week';
                    $description = 'Harga reguler';
                }
            }

            if ($price === null || $price === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Harga tidak tersedia untuk hari ini'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'villa_id' => $villa_id,
                    'date' => $date,
                    'day_of_week' => $dayOfWeek,
                    'season' => $activeSeason->nama_season,
                    'price' => $price,
                    'pricing_source' => $pricingSource,
                    'description' => $description
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get pricing for a villa within a date range
     */
    public function getPricingByDateRange($villa_id, $start_date, $end_date)
    {
        try {
            $startDate = Carbon::parse($start_date);
            $endDate = Carbon::parse($end_date);
            $pricing = [];

            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $response = $this->getPricingByDate($villa_id, $currentDate->format('Y-m-d'));
                $responseData = json_decode($response->getContent(), true);

                if ($responseData['success']) {
                    $pricing[] = $responseData['data'];
                } else {
                    $pricing[] = [
                        'date' => $currentDate->format('Y-m-d'),
                        'day_of_week' => $currentDate->dayOfWeek,
                        'available' => false,
                        'reason' => $responseData['message']
                    ];
                }

                $currentDate->addDay();
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'villa_id' => $villa_id,
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'pricing' => $pricing,
                    'total_days' => count($pricing),
                    'available_days' => count(array_filter($pricing, function($day) {
                        return isset($day['price']) || ($day['available'] ?? false);
                    }))
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get active seasons for a specific date
     */
    public function getActiveSeasons($date = null)
    {
        try {
            $targetDate = $date ? Carbon::parse($date) : Carbon::now();

            $activeSeasons = Season::where('tgl_mulai_season', '<=', $targetDate)
                                  ->where('tgl_selesai_season', '>=', $targetDate)
                                  ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'date' => $targetDate->format('Y-m-d'),
                    'active_seasons' => $activeSeasons
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk menambahkan range date price baru
     */
    public function addRangeDatePrice(Request $request, $id_villa_pricing)
    {
        try {
            $pricing = VillaPricing::findOrFail($id_villa_pricing);
            $season = Season::findOrFail($pricing->season_id);

            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'price' => 'required|integer|min:0',
                'description' => 'nullable|string|max:255',
            ]);

            // Validasi range tanggal sesuai dengan season
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);

            if (!$season->repeat_weekly) {
                // Jika season tidak repeat_weekly, pastikan range tanggal berada dalam range tanggal season
                if ($startDate->lt($season->tgl_mulai_season) || $endDate->gt($season->tgl_akhir_season)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Range tanggal harus berada dalam range tanggal season.'
                    ], 400);
                }
            }

            // Generate dates array
            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                // Jika season repeat_weekly, pastikan hanya hari yang ada di days_of_week yang digunakan
                if ($season->repeat_weekly && !in_array($currentDate->dayOfWeek, $season->days_of_week)) {
                    $currentDate->addDay();
                    continue;
                }

                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            // Jika tidak ada tanggal yang valid, return error
            if (empty($dates)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada tanggal yang valid dalam range yang dipilih.'
                ], 400);
            }

            $rangeDatePrice = [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'dates' => $dates,
                'price' => $validated['price'],
                'description' => $validated['description'] ?? 'Harga khusus untuk periode tertentu'
            ];

            // Tambahkan range date price baru
            $pricing->addRangeDatePrice($rangeDatePrice);
            $pricing->save();

            return response()->json([
                'success' => true,
                'message' => 'Range date price berhasil ditambahkan',
                'data' => $rangeDatePrice
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk menambahkan special price range baru
     */
    public function addSpecialPriceRange(Request $request, $id_villa_pricing)
    {
        try {
            $pricing = VillaPricing::findOrFail($id_villa_pricing);
            $season = Season::findOrFail($pricing->season_id);

            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'price' => 'required|integer|min:0',
                'description' => 'nullable|string|max:255',
            ]);

            // Validasi range tanggal sesuai dengan season
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);

            if (!$season->repeat_weekly) {
                // Jika season tidak repeat_weekly, pastikan range tanggal berada dalam range tanggal season
                if ($startDate->lt($season->tgl_mulai_season) || $endDate->gt($season->tgl_akhir_season)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Range tanggal harus berada dalam range tanggal season.'
                    ], 400);
                }
            }

            // Generate dates array
            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                // Jika season repeat_weekly, pastikan hanya hari yang ada di days_of_week yang digunakan
                if ($season->repeat_weekly && !in_array($currentDate->dayOfWeek, $season->days_of_week)) {
                    $currentDate->addDay();
                    continue;
                }

                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            // Jika tidak ada tanggal yang valid, return error
            if (empty($dates)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada tanggal yang valid dalam range yang dipilih.'
                ], 400);
            }

            $specialPriceRange = [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'dates' => $dates,
                'price' => $validated['price'],
                'description' => $validated['description'] ?? 'Special price untuk tanggal tertentu'
            ];

            // Tambahkan special price range baru
            $pricing->addSpecialPriceRange($specialPriceRange);
            $pricing->save();

            return response()->json([
                'success' => true,
                'message' => 'Special price range berhasil ditambahkan',
                'data' => $specialPriceRange
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk mendapatkan semua range date price
     */
    public function getRangeDatePrices($id_villa_pricing)
    {
        try {
            $pricing = VillaPricing::findOrFail($id_villa_pricing);

            return response()->json([
                'success' => true,
                'data' => $pricing->getAllRangeDatePrices()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * API untuk mendapatkan semua special price range
     */
    public function getSpecialPriceRanges($id_villa_pricing)
    {
        try {
            $pricing = VillaPricing::findOrFail($id_villa_pricing);

            return response()->json([
                'success' => true,
                'data' => $pricing->getAllSpecialPriceRanges()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
