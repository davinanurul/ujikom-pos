<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('member.index', compact('members'));
    }

    public function create()
    {
        return view('member.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $validatedData['tanggal_bergabung'] = now();
        $validatedData['status'] = 'aktif';

        Member::create($validatedData);

        return redirect()->route('member.index')->with('success', 'Member berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('member.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|numeric',
            'alamat' => 'required|string|max:255',
        ]);

        $member = Member::findOrFail($id);
        $member->nama = $request->nama;
        $member->telepon = $request->telepon;
        $member->alamat = $request->alamat;
        $member->save();

        return redirect()->route('member.index')->with('success', 'Data member berhasil diperbarui.');
    }

    public function nonaktifkanAkun($memberId)
    {
        $member = Member::findOrFail($memberId);
        $member->status = 'nonaktif';
        $member->save();

        return redirect()->route('member.index')->with('success', 'Member berhasil dinonaktifkan.');
    }

    public function aktifkanAkun($memberId)
    {
        $member = Member::findOrFail($memberId);
        $member->status = 'aktif';
        $member->save();

        return redirect()->route('member.index')->with('success', 'Pengguna berhasil diaktifkan.');
    }
}
