<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use App\Models\Season;
use App\Models\VillaPricing;
use Illuminate\Http\Request;

class VillaPricingController extends Controller
{
    public function index()
    {
        // Tampilkan daftar (bisa diubah sesuai kebutuhan Livewire/Table Anda)
        $items = VillaPricing::with(['villa','season'])->get();
        return view('harga-villa.index', compact('items'));
    }

    public function create()
    {
        $villas  = Villa::all();
        $seasons = Season::orderByDesc('tgl_mulai_season')->get();
        return view('harga-villa.create', compact('villas','seasons'));
    }

    public function store(Request $request)
    {
        // ambil semua input tanpa validasi
        $data     = $request->all();
        $seasonId = $data['season_id'];
        $season   = Season::findOrFail($seasonId);

        // map index hari → kolom db
        $mapHari = [
            0 => 'sunday_pricing',
            1 => 'monday_pricing',
            2 => 'tuesday_pricing',
            3 => 'wednesday_pricing',
            4 => 'thursday_pricing',
            5 => 'friday_pricing',
            6 => 'saturday_pricing',
        ];

        $fields = [];

        // jika user klik "all same" untuk season tertentu
        if (! empty($data['all_same'][$seasonId])) {
            $gp = $data['group_pricing'][$seasonId] ?? 0;
            foreach ($season->days_of_week as $dow) {
                $fields[$mapHari[$dow]] = $gp;
            }
        }
        // weekly individual
        elseif ($season->repeat_weekly) {
            foreach ($season->days_of_week as $dow) {
                $key = $mapHari[$dow];
                $fields[$key] = $data['pricing'][$seasonId][$key] ?? 0;
            }
        }
        // non-weekly (rentang)
        else {
            foreach ($mapHari as $col) {
                $fields[$col] = $data['pricing'][$seasonId][$col] ?? 0;
            }
        }

        VillaPricing::updateOrCreate(
            ['villa_id' => $data['villa_id'], 'season_id' => $seasonId],
            $fields
        );

        return redirect()
            ->route('harga-villa.index')
            ->with('success','Data berhasil disimpan.');
    }

    public function edit(VillaPricing $harga_villa)
    {
        $villas        = Villa::all();
        $seasons       = Season::orderByDesc('tgl_mulai_season')->get();
        $villa_pricing = $harga_villa;
        return view('harga-villa.edit', compact('villas','seasons','villa_pricing'));
    }

    public function update(Request $request, VillaPricing $villa_pricing)
    {
        $data     = $request->all();
        $seasonId = $data['season_id'];
        $season   = Season::findOrFail($seasonId);

        $mapHari = [
            0 => 'sunday_pricing',
            1 => 'monday_pricing',
            2 => 'tuesday_pricing',
            3 => 'wednesday_pricing',
            4 => 'thursday_pricing',
            5 => 'friday_pricing',
            6 => 'saturday_pricing',
        ];

        $fields = [];

        if (! empty($data['all_same'][$seasonId])) {
            $gp = $data['group_pricing'][$seasonId] ?? 0;
            foreach ($season->days_of_week as $dow) {
                $fields[$mapHari[$dow]] = $gp;
            }
        }
        elseif ($season->repeat_weekly) {
            foreach ($season->days_of_week as $dow) {
                $key = $mapHari[$dow];
                $fields[$key] = $data['pricing'][$seasonId][$key] ?? 0;
            }
        }
        else {
            foreach ($mapHari as $col) {
                $fields[$col] = $data['pricing'][$seasonId][$col] ?? 0;
            }
        }

        $villa_pricing->update(array_merge([
            'villa_id'   => $data['villa_id'],
            'season_id'  => $seasonId,
        ], $fields));

        return redirect()
            ->route('harga-villa.index')
            ->with('success','Data berhasil diperbarui.');
    }

    public function destroy(VillaPricing $villa_pricing)
    {
        $villa_pricing->delete();
        return redirect()
            ->route('harga-villa.index')
            ->with('success','Data berhasil dihapus.');
    }
}
