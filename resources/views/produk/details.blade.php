@extends('layouts.layout')
@section('title', 'Produk')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fa fa-truck text-primary mr-2"></i> Data Detail Produk</h4>
            <div>
                <a href="{{ route('produk_varian.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus mr-1"></i> Tambah
                </a>
                <button class="btn btn-warning text-white" onclick="window.print();">
                    <i class="fa fa-print mr-1 text=white"></i> Print/Ekspor
                </button>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive mb-5">
                <table class="table table-striped table-bordered zero-configuration">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Barcode</th>
                                <th class="text-center">SKU</th>
                                <th class="text-center">Nama Produk</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkVarians as $index => $varian)
                                <tr>
                                    <td class="text-center align-middle">{{ $index + 1 }}</td>
                                    <td class="text-center align-middle">
                                        {!! DNS1D::getBarcodeHTML($produk->kode, 'C128', 1.5, 50) !!}
                                    </td>
                                    <td class="text-center align-middle">{{ $varian->sku }}</td>
                                    <td class="text-center align-middle">{{ $varian->produk->nama }}</td>
                                    <td class="text-center align-middle">{{ $varian->size }}</td>
                                    <td class="text-center align-middle">{{ $varian->warna }}</td>
                                    <td class="text-center align-middle">{{ $varian->harga_jual }}</td>
                                    <td class="text-center align-middle">{{ $varian->stok }}</td>
                                    <td class="text-center align-middle" style="width: 12%">
                                        <a href="{{ route('penerimaan_barang.create') }}" class="btn btn-warning btn-sm">
                                            <i class="fas fa-box-open"></i> Restok
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: {!! json_encode(session('success')) !!}
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: {!! json_encode(session('error')) !!}
                });
            @endif
        });
    </script>
@endsection
