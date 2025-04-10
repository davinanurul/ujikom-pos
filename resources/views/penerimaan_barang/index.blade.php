@extends('layouts.layout')
@section('title', 'Penerimaan Barang')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('penerimaan_barang.create')}}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
            <button class="btn btn-success" onclick="window.print();">
                <i class="fas fa-print"></i> Print/Ekspor
            </button>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel data Penerimaan Barang</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Supplier</th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($restoks as $index => $restok)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $restok->supplier->nama }}</td>
                                    <td class="text-center">{{ $restok->produk->nama }}</td>
                                    <td class="text-center">{{ $restok->varian->size }}</td>
                                    <td class="text-center">{{ $restok->varian->warna }}</td>
                                    <td class="text-center">{{ number_format($restok->harga_beli) }}</td>
                                    <td class="text-center">{{ $restok->qty }}</td>
                                    <td class="text-center" style="width: 12%">
                                        <a href="{{route('penerimaan_barang.details', $restok->id)}}" class="btn btn-warning">
                                            <i class="fa fa-eye"></i> Detail
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