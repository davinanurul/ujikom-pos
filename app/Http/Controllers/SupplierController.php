<?php

namespace App\Http\Controllers;

use App\Exports\SupplierExport;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Imports\SupplierImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    // Menampilkan daftar semua supplier
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));
    }

    // Menampilkan form untuk menambahkan supplier baru
    public function create()
    {
        return view('supplier.create');
    }

    // Menyimpan data supplier baru
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

    // Menampilkan form untuk mengedit data supplier yang sudah ada
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit', compact('supplier'));
    }

    // Memperbarui data supplier yang sudah ada
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

    // Mengimpor data supplier dari file Excel
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

    // Mengekspor data ke pdf
    public function exportPDF()
    {
        $suppliers = Supplier::all();

        $pdf = Pdf::loadView('supplier.pdf', compact('suppliers'));
        return $pdf->download('daftar_supplier.pdf');
    }

    // Mengekspor data ke excel
    public function exportExcel()
    {
        return Excel::download(new SupplierExport, 'daftar_supplier.xlsx');
    }
}
