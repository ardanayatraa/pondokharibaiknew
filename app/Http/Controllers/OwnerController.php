<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    /**
     * Tampilkan daftar owner.
     */
    public function index()
    {
        $owners = Owner::paginate(10);
        return view('owner.index', compact('owners'));
    }

    /**
     * Tampilkan form pembuatan owner baru.
     */
    public function create()
    {
        return view('owner.create');
    }

    /**
     * Simpan owner baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:tbl_owner,username',
            'email'    => 'required|email|unique:tbl_owner,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Hash password sebelum simpan
        $validated['password'] = Hash::make($validated['password']);

        Owner::create($validated);

        return redirect()
            ->route('owner.index')
            ->with('success', 'Owner berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu owner.
     */
    public function show(Owner $owner)
    {
        return view('owner.show', compact('owner'));
    }

    /**
     * Tampilkan form edit owner.
     */
    public function edit(Owner $owner)
    {
        return view('owner.edit', compact('owner'));
    }

    /**
     * Update data owner.
     */
    public function update(Request $request, Owner $owner)
    {
        $rules = [
            'username' => 'required|string|max:255|unique:tbl_owner,username,' . $owner->id_owner . ',id_owner',
            'email'    => 'required|email|unique:tbl_owner,email,'    . $owner->id_owner . ',id_owner',
        ];

        // Jika mengisi password baru, wajib konfirmasi
        if ($request->filled('password')) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $owner->update($validated);

        return redirect()
            ->route('owner.index')
            ->with('success', 'Owner berhasil diupdate.');
    }

    /**
     * Hapus owner.
     */
    public function destroy(Owner $owner)
    {
        $owner->delete();

        return redirect()
            ->route('owner.index')
            ->with('success', 'Owner berhasil dihapus.');
    }
}
