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
        // Urutkan season berdasarkan tanggal mulai (terbaru dulu)
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

        // Jika ada rentang tanggal yang dipilih, simpan ke range_date_price
        $rangeDatePrice = null;
        if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);

            // Buat array tanggal dalam rentang
            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            $rangeDatePrice = [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'dates' => $dates,
                'price' => $validated['special_price'] ?? null
            ];

            // Hapus field yang tidak ada di model
            unset($validated['start_date']);
            unset($validated['end_date']);
        }

        // Tambahkan range_date_price ke data yang akan disimpan
        if ($rangeDatePrice) {
            $validated['range_date_price'] = $rangeDatePrice;
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

        // Jika ada rentang tanggal yang dipilih, simpan ke range_date_price
        $rangeDatePrice = null;
        if (!empty($validated['start_date']) && !empty($validated['end_date'])) {
            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);

            // Buat array tanggal dalam rentang
            $dates = [];
            $currentDate = $startDate->copy();
            while ($currentDate->lte($endDate)) {
                $dates[] = $currentDate->format('Y-m-d');
                $currentDate->addDay();
            }

            $rangeDatePrice = [
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'dates' => $dates,
                'price' => $validated['special_price'] ?? null
            ];

            // Hapus field yang tidak ada di model
            unset($validated['start_date']);
            unset($validated['end_date']);
        }

        // Tambahkan range_date_price ke data yang akan disimpan
        if ($rangeDatePrice) {
            $validated['range_date_price'] = $rangeDatePrice;
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
            $dayOfWeek = $targetDate->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
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

            // Cek apakah tanggal ini ada dalam range_date_price
            $price = null;
            $pricingSource = null;

            if ($pricing->range_date_price && isset($pricing->range_date_price['dates']) &&
                in_array($dateString, $pricing->range_date_price['dates']) &&
                isset($pricing->range_date_price['price']) &&
                $pricing->range_date_price['price'] > 0) {

                // Gunakan harga dari range_date_price
                $price = $pricing->range_date_price['price'];
                $pricingSource = 'range_date_price';
            }
            // Jika menggunakan special_price
            else if ($pricing->use_special_price && $pricing->special_price > 0) {
                $price = $pricing->special_price;
                $pricingSource = 'special_price';
            }
            // Jika tidak ada range_date_price atau special_price, gunakan harga per hari
            else {
                // Mapping day of week ke field pricing
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
                    'pricing_source' => $pricingSource
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

            // Cari pricing untuk villa ini
            $villaPricing = VillaPricing::where('villa_id', $villa_id)->get();

            // Cek apakah ada pricing dengan range_date_price yang mencakup rentang tanggal ini
            $rangeDatePricing = $villaPricing->first(function($item) use ($start_date, $end_date) {
                if (!$item->range_date_price) return false;

                $rangeStartDate = $item->range_date_price['start_date'] ?? null;
                $rangeEndDate = $item->range_date_price['end_date'] ?? null;

                if (!$rangeStartDate || !$rangeEndDate) return false;

                // Cek apakah rentang tanggal pricing mencakup rentang tanggal yang diminta
                return Carbon::parse($rangeStartDate)->lte(Carbon::parse($start_date)) &&
                       Carbon::parse($rangeEndDate)->gte(Carbon::parse($end_date));
            });

            // Jika ada range_date_price yang cocok, gunakan itu
            if ($rangeDatePricing && isset($rangeDatePricing->range_date_price['price']) &&
                $rangeDatePricing->range_date_price['price'] > 0) {

                $price = $rangeDatePricing->range_date_price['price'];

                // Buat data pricing untuk setiap hari dalam rentang
                $currentDate = $startDate->copy();
                while ($currentDate->lte($endDate)) {
                    $pricing[] = [
                        'date' => $currentDate->format('Y-m-d'),
                        'day_of_week' => $currentDate->dayOfWeek,
                        'season' => $rangeDatePricing->season->nama_season,
                        'price' => $price,
                        'pricing_source' => 'range_date_price',
                        'available' => true
                    ];
                    $currentDate->addDay();
                }
            }
            // Jika tidak ada range_date_price yang cocok, gunakan metode per hari
            else {
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
}
