<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    /**
     * Tampilkan daftar season.
     */
    public function index()
    {
        // Urutkan berdasarkan priority (desc), lalu tgl_mulai (desc)
        $seasons = Season::orderByDesc('priority')
                         ->orderByDesc('tgl_mulai_season')
                         ->get();

        return view('season.index', compact('seasons'));
    }

    /**
     * Tampilkan form pembuatan season baru.
     */
    public function create()
    {
        $daysOfWeek = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        return view('season.create', compact('daysOfWeek'));
    }

    /**
     * Simpan season baru ke database (tanpa validasi otomatis).
     */
    public function store(Request $request)
    {
        // Validasi input
        $rules = [
            'nama_season' => 'required|string|max:255',
            'repeat_weekly' => 'required|boolean',
            'priority' => 'required|integer|min:0',
        ];

        // Tambahkan validasi berdasarkan tipe season
        if ($request->repeat_weekly) {
            $rules['days_of_week'] = 'required|array|min:1';
            $rules['days_of_week.*'] = 'integer|between:0,6';
        } else {
            $rules['tgl_mulai_season'] = 'required|date';
            $rules['tgl_akhir_season'] = 'required|date|after_or_equal:tgl_mulai_season';
        }

        $validated = $request->validate($rules);

        // Persiapkan data untuk disimpan
        $data = [
            'nama_season'      => $validated['nama_season'],
            'repeat_weekly'    => (bool) $validated['repeat_weekly'],
            'days_of_week'     => $validated['repeat_weekly']
                                   ? $validated['days_of_week']
                                   : null,
            'tgl_mulai_season' => $validated['repeat_weekly'] ? null : $validated['tgl_mulai_season'],
            'tgl_akhir_season' => $validated['repeat_weekly'] ? null : $validated['tgl_akhir_season'],
            'priority'         => $validated['priority'],
        ];

        Season::create($data);

        return redirect()
            ->route('season.index')
            ->with('success', 'Season berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu season.
     */
    public function show(Season $season)
    {
        return view('season.show', compact('season'));
    }

    /**
     * Tampilkan form edit season.
     */
    public function edit(Season $season)
    {
        $daysOfWeek = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        return view('season.edit', compact('season', 'daysOfWeek'));
    }

    /**
     * Update data season (tanpa validasi otomatis).
     */
    public function update(Request $request, Season $season)
    {
        // Validasi input
        $rules = [
            'nama_season' => 'required|string|max:255',
            'repeat_weekly' => 'required|boolean',
            'priority' => 'required|integer|min:0',
        ];

        // Tambahkan validasi berdasarkan tipe season
        if ($request->repeat_weekly) {
            $rules['days_of_week'] = 'required|array|min:1';
            $rules['days_of_week.*'] = 'integer|between:0,6';
        } else {
            $rules['tgl_mulai_season'] = 'required|date';
            $rules['tgl_akhir_season'] = 'required|date|after_or_equal:tgl_mulai_season';
        }

        $validated = $request->validate($rules);

        // Persiapkan data untuk disimpan
        $data = [
            'nama_season'      => $validated['nama_season'],
            'repeat_weekly'    => (bool) $validated['repeat_weekly'],
            'days_of_week'     => $validated['repeat_weekly']
                                   ? $validated['days_of_week']
                                   : null,
            'tgl_mulai_season' => $validated['repeat_weekly'] ? null : $validated['tgl_mulai_season'],
            'tgl_akhir_season' => $validated['repeat_weekly'] ? null : $validated['tgl_akhir_season'],
            'priority'         => $validated['priority'],
        ];

        $season->update($data);

        return redirect()
            ->route('season.index')
            ->with('success', 'Season berhasil diupdate.');
    }

    /**
     * Hapus season.
     */
    public function destroy(Season $season)
    {
        $season->delete();

        return redirect()
            ->route('season.index')
            ->with('success', 'Season berhasil dihapus.');
    }
}
