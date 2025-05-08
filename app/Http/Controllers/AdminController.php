<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Tampilkan daftar admin.
     */
    public function index()
    {
        $admins = Admin::paginate(10);
        return view('admin.index', compact('admins'));
    }

    /**
     * Tampilkan form pembuatan admin baru.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Simpan admin baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:tbl_admin,username',
            'email'    => 'required|email|unique:tbl_admin,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Hash password sebelum simpan
        $validated['password'] = Hash::make($validated['password']);

        Admin::create($validated);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Admin berhasil dibuat.');
    }

    /**
     * Tampilkan detail 1 admin.
     */
    public function show(Admin $admin)
    {
        return view('admin.show', compact('admin'));
    }

    /**
     * Tampilkan form edit admin.
     */
    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    /**
     * Update data admin.
     */
    public function update(Request $request, Admin $admin)
    {
        $rules = [
            'username' => 'required|string|max:255|unique:tbl_admin,username,' . $admin->id_admin . ',id_admin',
            'email'    => 'required|email|unique:tbl_admin,email,'    . $admin->id_admin . ',id_admin',
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

        $admin->update($validated);

        return redirect()
            ->route('admin.index')
            ->with('success', 'Admin berhasil diupdate.');
    }

    /**
     * Hapus admin.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()
            ->route('admin.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
