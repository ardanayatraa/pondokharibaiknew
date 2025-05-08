<?php

namespace App\Http\Controllers;

use App\Models\Villa;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VillaController extends Controller
{
    public function index()
    {
        $villas = Villa::orderBy('id_villa','desc')->paginate(10);
        return view('villa.index', compact('villas'));
    }

    public function create()
    {
        $facilities = Facility::orderBy('facility_type')
                              ->get()
                              ->groupBy('facility_type');

        return view('villa.create', compact('facilities'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'facility_id'   => 'required|array',
            'facility_id.*' => 'exists:tbl_facility,id_facility',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'picture'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'capacity'      => 'required|integer|min:1',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('villas', 'public');
        }

        // Buat villa baru
        Villa::create($validated);

        return redirect()
            ->route('villa.index')
            ->with('success', 'Villa berhasil ditambahkan.');
    }


    public function show(Villa $villa)
    {
        return view('villa.show', compact('villa'));
    }

    public function edit(Villa $villa)
    {
        $facilities = Facility::orderBy('facility_type')
                              ->get()
                              ->groupBy('facility_type');

        return view('villa.edit', compact('villa','facilities'));
    }

    public function update(Request $request, Villa $villa)
    {
        $validated = $request->validate([
            'facility_id'   => 'required|array',
            'facility_id.*' => 'exists:tbl_facility,id_facility',
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'picture'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'capacity'      => 'required|integer|min:1',
        ]);

        if ($request->hasFile('picture')) {
            if ($villa->picture) {
                Storage::disk('public')->delete($villa->picture);
            }
            $validated['picture'] = $request->file('picture')
                                           ->store('villas','public');
        } else {
            unset($validated['picture']);
        }



        $villa->update($validated);

        return redirect()
            ->route('villa.index')
            ->with('success','Villa berhasil diupdate.');
    }

    public function destroy(Villa $villa)
    {
        if ($villa->picture) {
            Storage::disk('public')->delete($villa->picture);
        }
        $villa->delete();

        return redirect()
            ->route('villa.index')
            ->with('success','Villa berhasil dihapus.');
    }
}
