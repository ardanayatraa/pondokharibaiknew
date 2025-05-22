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
        // Urutkan dulu berdasarkan priority (desc), lalu tanggal mulai (desc)
        $seasons = Season::orderByDesc('priority')->get();
        return view('season.index', compact('seasons'));
    }

    /**
     * Tampilkan form pembuatan season baru.
     */
    public function create()
    {
        // Untuk pilihan hari, kita butuh array 0..6
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
     * Simpan season baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_season'      => 'required|string|max:255',
            'repeat_weekly'    => 'required|boolean',
            'days_of_week'     => 'nullable|array',
            'days_of_week.*'   => 'integer|in:0,1,2,3,4,5,6',
            'tgl_mulai_season' => 'required_if:repeat_weekly,false|date',
            'tgl_akhir_season' => 'required_if:repeat_weekly,false|date|after_or_equal:tgl_mulai_season',
            'priority'         => 'required|integer|min:0',
        ]);

        // Jika bukan weekly thì kosongkan days_of_week
        if (! (bool) $validated['repeat_weekly']) {
            $validated['days_of_week'] = null;
        }

        Season::create($validated);

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
     * Update data season.
     */
    public function update(Request $request, Season $season)
    {
        $validated = $request->validate([
            'nama_season'      => 'required|string|max:255',
            'repeat_weekly'    => 'required|boolean',
            'days_of_week'     => 'nullable|array',
            'days_of_week.*'   => 'integer|in:0,1,2,3,4,5,6',
            'tgl_mulai_season' => 'required_if:repeat_weekly,false|date',
            'tgl_akhir_season' => 'required_if:repeat_weekly,false|date|after_or_equal:tgl_mulai_season',
            'priority'         => 'required|integer|min:0',
        ]);

        if (! (bool) $validated['repeat_weekly']) {
            $validated['days_of_week'] = null;
        }

        $season->update($validated);

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
