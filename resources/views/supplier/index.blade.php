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
                    <i class="fa fa-print text-white mr-1"></i>Ekspor
                </button>
                <button type="button" class="btn btn-primary text-white" data-toggle="modal"
                    data-target="#importSupplierModal">
                    <i class="fa fa-file mr-1"></i> Impor
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
                                    <a href="{{ route('supplier.edit', $supplier->id) }}"
                                        class="btn btn-sm btn-success text-white">
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

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importSupplierModal" tabindex="-1" role="dialog"
        aria-labelledby="importSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('supplier.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importSupplierModalLabel">Impor Supplier dari Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Pilih File Excel</label>
                            <input type="file" name="file" class="form-control" required>
                            <small class="text-muted">File harus berekstensi .xls atau .xlsx</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Impor</button>
                    </div>
                </div>
            </form>
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
