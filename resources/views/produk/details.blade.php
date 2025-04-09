@extends('layouts.layout')
@section('title', 'Produk')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('produk_varian.create')}}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Varian Produk
        </a>
        <button class="btn btn-success" onclick="window.print();">
            <i class="fas fa-print"></i> Print/Ekspor
        </button>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Varian Produk {{ $produk->nama}}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Gambar</th>
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
                                    @if($varian->gambar)
                                        <img src="{{ asset('storage/' . $varian->gambar) }}" alt="Gambar Produk" class="img-thumbnail" style="width: 75px; height: 75px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">Tidak Ada Gambar</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">{{ $varian->produk->nama }}</td>
                                <td class="text-center align-middle">{{ $varian->size }}</td>
                                <td class="text-center align-middle">{{ $varian->warna }}</td>
                                <td class="text-center align-middle">{{ $varian->harga_jual }}</td>
                                <td class="text-center align-middle">{{ $varian->stok }}</td>
                                <td class="text-center align-middle" style="width: 12%">
                                    <a href="{{ route('penerimaan_barang.create')}}" class="btn btn-warning btn-sm">
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