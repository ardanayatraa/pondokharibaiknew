<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GuestController extends Controller
{
    /**
     * Tampilkan daftar guest.
     */
    public function index()
    {
        $guests = Guest::paginate(10);
        return view('guest.index', compact('guests'));
    }

    /**
     * Tampilkan form pembuatan guest baru.
     */
    public function create()
    {
        return view('guest.create');
    }

    /**
     * Simpan guest baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'        => 'required|string|max:255|unique:tbl_guest,username',
            'email'           => 'required|email|unique:tbl_guest,email',
            'password'        => 'required|string|min:6|confirmed',
            'full_name'       => 'required|string|max:255',
            'address'         => 'nullable|string',
            'phone_number'    => 'nullable|string|max:20',
            'id_card_number'  => 'nullable|string|max:50',
            'passport_number' => 'nullable|string|max:50',
            'birthdate'       => 'nullable|date',
            'gender'          => 'nullable|in:male,female',
        ]);

        // Hash password sebelum simpan
        $validated['password'] = Hash::make($validated['password']);

        Guest::create($validated);

        return redirect()
            ->route('guest.index')
            ->with('success', 'Guest berhasil dibuat.');
    }

    /**
     * Tampilkan detail satu guest.
     */
    public function show(Guest $guest)
    {
        return view('guest.show', compact('guest'));
    }

    /**
     * Tampilkan form edit guest.
     */
    public function edit(Guest $guest)
    {
        return view('guest.edit', compact('guest'));
    }

    /**
     * Update data guest.
     */
    public function update(Request $request, Guest $guest)
    {

        $rules = [
            'username'        => 'required',
            'email'           => 'required',
            'full_name'       => 'required|string|max:255',
            'address'         => 'nullable|string',
            'phone_number'    => 'nullable|string|max:20',
            'id_card_number'  => 'nullable|string|max:50',
            'passport_number' => 'nullable|string|max:50',
            'birthdate'       => 'nullable|date',
            'gender'          => 'nullable|in:male,female',
        ];

        // Jika mengisi password baru, wajib confirm
        if ($request->filled('password')) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $guest->update($validated);


        if(Auth::guard('guest')->user()){
        return redirect('/');
        }
        return redirect()
            ->route('guest.index')
            ->with('success', 'Guest berhasil diupdate.');
    }

    /**
     * Hapus guest.
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();

        return redirect()
            ->route('guest.index')
            ->with('success', 'Guest berhasil dihapus.');
    }
}
