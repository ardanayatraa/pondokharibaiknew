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
        $seasons = Season::orderBy('tgl_mulai_season', 'desc')
            ->paginate(10);

        return view('season.index', compact('seasons'));
    }

    /**
     * Tampilkan form pembuatan season baru.
     */
    public function create()
    {
        return view('season.create');
    }

    /**
     * Simpan season baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_season'      => 'required|string|max:255',
            'tgl_mulai_season' => 'required|date',
            'tgl_akhir_season' => 'required|date|after_or_equal:tgl_mulai_season',
        ]);

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
        return view('season.edit', compact('season'));
    }

    /**
     * Update data season.
     */
    public function update(Request $request, Season $season)
    {
        $validated = $request->validate([
            'nama_season'      => 'required|string|max:255',
            'tgl_mulai_season' => 'required|date',
            'tgl_akhir_season' => 'required|date|after_or_equal:tgl_mulai_season',
        ]);

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
