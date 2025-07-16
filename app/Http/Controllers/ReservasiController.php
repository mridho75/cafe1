<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\UserCafe;
use App\Models\Member;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index()
    {
        if (!allowedRoles(['admin', 'kasir'])) {
            return redirect('/')->with('error', 'Akses hanya untuk Admin!');
        }

        $reservasis = Reservasi::with(['user', 'member'])->get();
        return view('reservasi.index', compact('reservasis'));
    }

    public function create()
    {
        $users = UserCafe::all();
        $members = Member::all();
        return view('reservasi.create', compact('users', 'members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:tb_users_cafe,id',
            'id_member' => 'nullable|exists:tb_members,id',
            'nama_pelanggan' => 'required|string|max:255',
            'tanggal_dibuat' => 'required|date',
            'tanggal_reservasi' => 'required|date',
            'nomor_meja' => 'required|string|max:20',
            'jumlah_kursi' => 'required|integer',
            'dp' => 'required|numeric',
        ]);

        try {
            // sudah_dipakai default false di DB, jadi gak perlu isi manual
            Reservasi::create($request->all());
            return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dibuat');
        } catch (\Exception $e) {
            return back()->with('error', 'Reservasi gagal disimpan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $users = UserCafe::all();
        $members = Member::all();
        return view('reservasi.edit', compact('reservasi', 'users', 'members'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_user' => 'required|exists:tb_users_cafe,id',
            'id_member' => 'nullable|exists:tb_members,id',
            'nama_pelanggan' => 'required|string|max:255',
            'tanggal_dibuat' => 'required|date',
            'tanggal_reservasi' => 'required|date',
            'nomor_meja' => 'required|string|max:20',
            'jumlah_kursi' => 'required|integer',
            'dp' => 'required|numeric',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update($request->all());

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil diperbarui');
    }

    public function destroy($id)
    {
        Reservasi::destroy($id);
        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil dihapus');
    }

    // Method baru untuk menandai reservasi sudah dipakai
    public function pakaiReservasi($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->sudah_dipakai) {
            return redirect()->route('reservasi.index')->with('error', 'Reservasi ini sudah pernah dipakai.');
        }

        $reservasi->sudah_dipakai = true;
        $reservasi->save();

        return redirect()->route('reservasi.index')->with('success', 'Reservasi berhasil digunakan.');
    }
}
