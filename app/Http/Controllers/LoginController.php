<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCafe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Menampilkan form login
    public function loginForm()
    {
        return view('auth.login'); // Pastikan view login sesuai dengan form yang kamu buat
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah username dan password sesuai
        $user = UserCafe::where('user_name', $request->username)->first();

        if ($user && Hash::check($request->password, $user->user_password)) {
            // Jika login berhasil, set session dan alihkan ke halaman home
            session([
                'user_id' => $user->id,
                'username' => $user->user_name,
                'role' => $user->role,
            ]);

            if ($user->role === 'admin') {
                return redirect('/')->with('success', 'Login berhasil sebagai Admin');
            } elseif ($user->role === 'kasir') {
                return redirect('/kasir/home')->with('success', 'Login berhasil sebagai Kasir');
            } elseif ($user->role === 'pemilik') {
                return redirect('/owner/laporan')->with('success', 'Login berhasil sebagai Pemilik');
            }
        }

        return back()->withErrors(['login' => 'Username atau password salah']);
    }


    // Logout
    public function logout(Request $request)
    {
        // Hapus session ketika logout
        $request->session()->flush();
        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}
