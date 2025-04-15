@extends('layouts.layout')
@section('title', 'Daftar Transaksi')
@section('content')
    <div class="container-fluid">
        <div class="d-md-flex justify-content-between align-items-center mb-3">
            <!-- Form Filter -->
            <div class="d-flex align-items-center gap-3">
                <form method="GET" action="{{ route('transaksi.index') }}" class="d-flex gap-3">
                    <input type="date" name="tanggal_mulai" class="form-control w-auto"
                        value="{{ request('tanggal_mulai') }}" class="form-control form-control-sm">
                    <input type="date" name="tanggal_selesai" class="form-control form-control-sm"
                        value="{{ request('tanggal_selesai') }}">

                    <button type="submit" class="btn btn-primary rounded-0">Filter</button>
                    <button type="button" class="btn btn-secondary rounded-0 text-white"
                        onclick="window.location='{{ route('transaksi.index') }}'">Reset</button>
                </form>
            </div>

            <!-- Export Dropdown -->
            <div class="dropdown">
                <button class="btn btn-warning dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-print mr-1"></i> Ekspor
                </button>
                <div class="dropdown-menu" aria-labelledby="exportDropdown">
                    <a class="dropdown-item"
                        href="{{ route('transaksi.exportPDF', ['tanggal_mulai' => request('tanggal_mulai'), 'tanggal_selesai' => request('tanggal_selesai')]) }}"
                        id="exportPDF">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a class="dropdown-item" href="{{ route('transactions.export', ['tanggal_mulai' => request('tanggal_mulai'), 'tanggal_selesai' => request('tanggal_selesai')]) }}">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </a>
                </div>
                
            </div>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive mb-5">
            <table class="table table-striped table-bordered zero-configuration">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Nomor Transaksi</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Kasir</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Pembayaran</th>
                        <th class="text-center">Member</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $index => $transaksi)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $transaksi->nomor_transaksi }}</td>
                            <td class="text-center">{{ $transaksi->tanggal }}</td>
                            <td class="text-center">{{ $transaksi->user->user_nama }}</td>
                            <td class="text-center">{{ number_format($transaksi->total) }}</td>
                            <td class="text-center">{{ $transaksi->pembayaran }}</td>
                            <td class="text-center">{{ $transaksi->member?->nama ?? '-' }}</td>
                            <td class="text-center" style="width: 20%">
                                <a href="{{ route('transaksi.details', $transaksi->id) }}" class="btn btn-primary">
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
@endsection

@push('script')
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
@endpush
