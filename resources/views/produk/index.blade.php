@extends('layouts.layout')
@section('title', 'Produk')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fa fa-truck text-primary mr-2"></i> Data Produk</h4>
        <div>
            <a href="{{ route('produk.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Produk
            </a>
            <button class="btn btn-success" onclick="window.print();">
                <i class="fa fa-print"></i> Print/Ekspor
            </button>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive mb-5">
            <table class="table table-striped table-bordered zero-configuration">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Supplier</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Kode</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $index => $produk)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $produk->supplier->nama }}</td>
                            <td class="text-center">{{ $produk->kategori->nama_kategori }}</td>
                            <td class="text-center">{{ $produk->kode }}</td>
                            <td class="text-center">{{ $produk->nama }}</td>
                            <td class="text-center" style="width: 20%">
                                <div class="btn-group">
                                    <a href="{{ route('produk.details', $produk->id) }}" class="btn btn-primary">
                                        Detail
                                    </a>
                                    <a href="{{ route('produk.edit', ['id' => $produk->id]) }}" class="btn btn-warning">
                                        Edit
                                    </a>
                                </div>                                        
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data.</td>
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
    document.addEventListener("DOMContentLoaded", function () {
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