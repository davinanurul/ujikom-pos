<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|numeric',
            'alamat' => 'required|string',
        ]);

        Supplier::create([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kontak' => 'required|numeric',
            'alamat' => 'required|string',
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'nama' => $request->nama,
            'kontak' => $request->kontak,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }
}
