<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Villa;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        // Ambil ID facility yang akan dihapus
        $deletedId = (string) $facility->id_facility;

        // Ambil semua villa yang memiliki facility_id mengandung ID tersebut
        $villas = Villa::whereJsonContains('facility_id', $deletedId)->get();

        foreach ($villas as $villa) {
            $current = $villa->facility_id ?? [];
            // Hapus ID yang ingin dihapus
            $filtered = array_values(array_filter($current, fn($id) => $id != $deletedId));
            // Simpan kembali
            $villa->facility_id = $filtered;
            $villa->save();
        }

        // Hapus facility-nya
        $facility->delete();

        return redirect()
            ->route('facility.index')
            ->with('success', 'Facility berhasil dihapus dan villa terkait telah diperbarui.');
    }
}
