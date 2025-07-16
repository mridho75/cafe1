<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetodePembayaranController extends Controller
{
    public function index()
    {
        if (!allowedRoles(['admin'])) {
            return redirect('/')->with('error', 'Akses ditolak!');
        }

        $metodes = DB::table('tb_metode_pembayaran')->get();
        return view('metode.index', compact('metodes'));
    }

    public function create()
    {
        return view('metode.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:255',
            'ikon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $data = $request->only(['nama_metode']);

        if ($request->hasFile('ikon')) {
            $file = $request->file('ikon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('metode_images'), $filename);
            $data['ikon'] = 'metode_images/' . $filename;
        }

        DB::table('tb_metode_pembayaran')->insert($data);

        return redirect()->route('metode.index')->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $metode = DB::table('tb_metode_pembayaran')->where('id', $id)->first();
        return view('metode.edit', compact('metode'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:255',
            'ikon' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $metode = DB::table('tb_metode_pembayaran')->where('id', $id)->first();
        $data = $request->only(['nama_metode']);

        if ($request->hasFile('ikon')) {
            if ($metode->ikon && file_exists(public_path($metode->ikon))) {
                unlink(public_path($metode->ikon));
            }

            $file = $request->file('ikon');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('metode_images'), $filename);
            $data['ikon'] = 'metode_images/' . $filename;
        }

        DB::table('tb_metode_pembayaran')->where('id', $id)->update($data);

        return redirect()->route('metode.index')->with('success', 'Metode pembayaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $metode = DB::table('tb_metode_pembayaran')->where('id', $id)->first();

        if ($metode->ikon && file_exists(public_path($metode->ikon))) {
            unlink(public_path($metode->ikon));
        }

        DB::table('tb_metode_pembayaran')->where('id', $id)->delete();

        return redirect()->route('metode.index')->with('success', 'Metode pembayaran berhasil dihapus!');
    }
}
