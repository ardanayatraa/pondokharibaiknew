<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Tampilkan daftar facility.
     */
    public function index()
    {
        $facilities = Facility::paginate(10);
        return view('facility.index', compact('facilities'));
    }

    /**
     * Tampilkan form pembuatan facility baru.
     */
    public function create()
    {
        return view('facility.create');
    }

    /**
     * Simpan facility baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_facility'  => 'required|string|max:255',
            'description'    => 'nullable|string',
            'facility_type'  => 'required|string|max:255',
        ]);

        Facility::create($validated);

        return redirect()
            ->route('facility.index')
            ->with('success', 'Facility berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu facility.
     */
    public function show(Facility $facility)
    {
        return view('facility.show', compact('facility'));
    }

    /**
     * Tampilkan form edit facility.
     */
    public function edit(Facility $facility)
    {
        return view('facility.edit', compact('facility'));
    }

    /**
     * Update data facility.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name_facility'  => 'required|string|max:255',
            'description'    => 'nullable|string',
            'facility_type'  => 'required|string|max:255',
        ]);

        $facility->update($validated);

        return redirect()
            ->route('facility.index')
            ->with('success', 'Facility berhasil diupdate.');
    }

    /**
     * Hapus facility.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();

        return redirect()
            ->route('facility.index')
            ->with('success', 'Facility berhasil dihapus.');
    }
}
