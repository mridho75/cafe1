<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        if (!allowedRoles(['admin', 'kasir'])) {
            return redirect('/')->with('error', 'Akses hanya untuk Admin!');
        }

        $members = Member::all();
        return view('member.index', compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_members' => 'required',
            'ttl' => 'required|date',
            'hp' => 'required',
            'alamat' => 'required',
            'status' => 'required|in:aktif,non-aktif,blacklist'
        ]);

        $kode = $this->generateKodeMember();

        Member::create([
            'kode_member' => $kode,
            'nama_members' => $request->nama_members,
            'ttl' => $request->ttl,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'nama_members' => 'required',
            'ttl' => 'required|date',
            'hp' => 'required',
            'alamat' => 'required',
            'status' => 'required|in:aktif,non-aktif,blacklist'
        ]);

        $member->update([
            'nama_members' => $request->nama_members,
            'ttl' => $request->ttl,
            'hp' => $request->hp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()->route('member.index')->with('success', 'Member berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Member::destroy($id);
        return redirect()->route('member.index')->with('success', 'Member berhasil dihapus.');
    }

    /**
     * Generate unique member code with prefix 'MBR'
     */
    private function generateKodeMember()
    {
        do {
            $kode = 'MBR' . strtoupper(Str::random(5));
        } while (Member::where('kode_member', $kode)->exists());

        return $kode;
    }
}
