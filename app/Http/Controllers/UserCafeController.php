<?php

namespace App\Http\Controllers;

use App\Models\UserCafe;
use Illuminate\Http\Request;

class UserCafeController extends Controller
{
    // Menampilkan semua data user
    public function index()
    {
        if (!allowedRoles(['admin'])) {
            return redirect('/')->with('error', 'Akses hanya untuk Admin!');
        }

        $users = UserCafe::all();
        return view('user.index', compact('users'));
    }

    // Menampilkan form tambah user
    public function create()
    {
        return view('user.create');
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|unique:tb_users_cafe,user_name',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,kasir,pemilik',
        ]);

        UserCafe::create([
            'user_name' => $validated['username'],
            'user_password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Menampilkan form edit user
    public function edit($id)
    {
        $user = UserCafe::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    // Menyimpan perubahan user
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'username' => 'required|unique:tb_users_cafe,user_name,' . $id,
            'password' => 'nullable|min:8',  // Validasi jika password diubah
            'role' => 'required|in:admin,kasir,pemilik',
        ]);

        $user = UserCafe::findOrFail($id);

        // Perbarui data user
        $user->update([
            'user_name' => $validated['username'],
            'user_password' => $validated['password'] ? bcrypt($validated['password']) : $user->user_password,
            'role' => $validated['role'],
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }

    // Menghapus user
    public function destroy($id)
    {
        $user = UserCafe::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }

    
}
