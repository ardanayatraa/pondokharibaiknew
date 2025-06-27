<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
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
            'username'     => 'required|string|max:255|unique:tbl_guest,username',
            'email'        => 'required|email|unique:tbl_guest,email',
            'phone_number' => 'required|string|max:20',
            'password'     => 'required|string|min:6|confirmed',
        ]);

        // Hash password sebelum simpan
        $validated['password'] = Hash::make($validated['password']);

        Guest::create($validated);

        // Cek apakah user sudah login sebagai guest
    if (Auth::guard('guest')->check()) {
        return redirect()
            ->route('guest.index')
            ->with('success', 'Guest berhasil dibuat.');
    }

    // Kalau belum login
    return redirect()
        ->route('login')
        ->with('success', 'Akun berhasil dibuat! Silakan login.');
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

        // Validasi semua field
        $rules = [
            'username'        => [
                'required', 'string', 'max:255',
                Rule::unique('tbl_guest', 'username')
                    ->ignore($guest->id_guest, 'id_guest'),
            ],
            'full_name'       => 'required|string|max:255',
            'email'           => [
                'required', 'email',
                Rule::unique('tbl_guest', 'email')
                    ->ignore($guest->id_guest, 'id_guest'),
            ],
            'phone_number'    => 'required|string|max:20',
            'address'         => 'nullable|string|max:500',
            'id_card_number'  => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:100',
            'birthdate'       => 'nullable|date',
            'gender'          => ['nullable', Rule::in(['male','female'])],
        ];

        // Jika user isi password, wajib confirmed dan minimal 6 karakter
        if ($request->filled('password')) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        $validated = $request->validate($rules);

        // Hash password jika diisi
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Simpan perubahan
        $guest->update($validated);

        // Redirect setelah update
        if (Auth::guard('guest')->check()) {
            return redirect('/')
                   ->with('success', 'Profil berhasil diperbarui.');
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




       /**
     * API: Update profil Guest yang sedang login (guard = guest).
     *
     * Endpoint ini di‐panggil dari JavaScript (fetch/Axios) dengan JSON body:
     * {
     *   "username": "...",
     *   "full_name": "...",
     *   "email": "...",
     *   "phone_number": "...",
     *   "address": "...",           // optional
     *   "id_card_number": "...",     // optional
     *   "passport_number": "...",    // optional
     *   "birthdate": "YYYY-MM-DD",   // optional
     *   "gender": "male" | "female", // optional
     *   // "password": "newpwd",      // (optional) jika ingin ganti password
     *   // "password_confirmation": "newpwd"
     * }
     *
     * Response: JSON { "success": true, "guest": { …data guest baru… } }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdateProfile(Request $request)
    {
        // Ambil model Guest yang sedang login lewat guard 'guest'
        /** @var \App\Models\Guest $guest */
        $guest = Auth::guard('guest')->user();

        // Jika tidak ada guest (harusnya middleware sudah memblokir)
        if (! $guest) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated as guest.'
            ], 401);
        }

        // Validasi semua field (sama seperti method update biasa, tapi kita ignore pengalihan/redirect)
        $rules = [
            'username'        => [
                'required', 'string', 'max:255',
                Rule::unique('tbl_guest', 'username')
                    ->ignore($guest->id_guest, 'id_guest'),
            ],
            'full_name'       => 'required|string|max:255',
            'email'           => [
                'required', 'email',
                Rule::unique('tbl_guest', 'email')
                    ->ignore($guest->id_guest, 'id_guest'),
            ],
            'phone_number'    => 'required|string|max:20',
            'address'         => 'nullable|string|max:500',
            'id_card_number'  => 'nullable|string|max:100',
            'passport_number' => 'nullable|string|max:100',
            'birthdate'       => 'nullable|date',
            'gender'          => ['nullable', Rule::in(['male','female'])],
        ];

        // Jika user mengirimkan field 'password', maka wajib confirmed serta minimal 6 karakter
        if ($request->filled('password')) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }

        // Jalankan validasi (jika gagal, otomatis response JSON 422 dengan detail error)
        $validated = $request->validate($rules);

        // Jika password diisi, hash sebelum disimpan; jika tidak, hapus dari array validated
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->input('password'));
        } else {
            unset($validated['password']);
        }

        // Update semua field ke database
        $guest->update($validated);

        // Kembalikan JSON dengan data guest terbaru
        return response()->json([
            'success' => true,
            'guest'   => $guest->fresh()  // fresh() untuk memastikan kita ambil data terkini
        ]);
    }

        public function updateUser(Request $request): JsonResponse
    {
        try {
            $guestId = $request->input('id');

            if (!$guestId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guest ID is required'
                ], 400);
            }

            $guest = Guest::findOrFail($guestId);

            // Validate request
            $validated = $request->validate([
                'username' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('tbl_guest', 'username')->ignore($guest->id_guest, 'id_guest')
                ],
                'full_name' => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('tbl_guest', 'email')->ignore($guest->id_guest, 'id_guest')
                ],
                'phone_number' => 'required|string|max:20',
                'address' => 'nullable|string|max:500',
                'id_card_number' => 'nullable|string|max:20',
                'passport_number' => 'nullable|string|max:20',
                'birthdate' => 'nullable|date',
                'gender' => 'nullable|in:male,female'
            ]);

            // Update guest
            $guest->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => $guest
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }
}
