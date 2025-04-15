@extends('layouts.layout')
@section('title', 'Penerimaan Barang')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fa fa-truck text-primary mr-2"></i> Penerimaan Barang</h4>
            <div>
                <a href="{{ route('penerimaan_barang.create')}}" class="btn btn-primary">
                    <i class="fa fa-plus mr-1"></i> Tambah
                </a>
                <button class="btn btn-warning" onclick="window.print();">
                    <i class="fa fa-print mr-1"></i> Print/Ekspor
                </button>
            </div>
        </div>
        
        <div class="card">
            <div class="table-responsive mb-5">
                <table class="table table-striped table-bordered zero-configuration">
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