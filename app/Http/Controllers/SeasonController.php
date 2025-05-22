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
        // Ambil semua field sesuai fillable
        $data = [
            'nama_season'      => $request->nama_season,
            'repeat_weekly'    => (bool) $request->repeat_weekly,
            // hanya set days_of_week jika weekly
            'days_of_week'     => $request->repeat_weekly
                                   ? $request->input('days_of_week', [])
                                   : null,
            'tgl_mulai_season' => $request->tgl_mulai_season,
            'tgl_akhir_season' => $request->tgl_akhir_season,
            'priority'         => $request->priority,
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
        $data = [
            'nama_season'      => $request->nama_season,
            'repeat_weekly'    => (bool) $request->repeat_weekly,
            'days_of_week'     => $request->repeat_weekly
                                   ? $request->input('days_of_week', [])
                                   : null,
            'tgl_mulai_season' => $request->tgl_mulai_season,
            'tgl_akhir_season' => $request->tgl_akhir_season,
            'priority'         => $request->priority,
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
