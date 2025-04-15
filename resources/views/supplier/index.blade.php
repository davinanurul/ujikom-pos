@extends('layouts.layout')
@section('title', 'Supplier')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fa fa-truck text-primary mr-2"></i> Data Supplier</h4>
        <div>
            <a href="{{ route('supplier.create') }}" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i> Tambah Supplier
            </a>
            <button class="btn btn-warning text-white" onclick="window.print();">
                <i class="fa fa-print text-white mr-1"></i> Print/Ekspor
            </button>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive mb-5">
            <table class="table table-striped table-bordered zero-configuration">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Kontak</th>
                        <th class="text-center">Alamat</th>
                        <th class="text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($suppliers as $index => $supplier)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $supplier->nama }}</td>
                            <td class="text-center">{{ $supplier->kontak }}</td>
                            <td class="text-center">{{ $supplier->alamat }}</td>
                            <td class="text-center">
                                <a href="{{ route('supplier.edit', $supplier->id) }}" class="btn btn-sm btn-success text-white">
                                    <i class="fa fa-edit text-white"></i> Edit
                                </a>
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