<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Imports\SupplierImport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new SupplierImport, $request->file('file'));
            return redirect()->route('supplier.index')->with('success', 'Data supplier berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->route('supplier.index')->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }
}
