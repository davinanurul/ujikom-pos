@extends('layouts.layout')
@section('title', 'Daftar Transaksi')
@section('content')
    <div class="container-fluid">
        <div class="d-md-flex justify-content-between align-items-center mb-3">
            <!-- Form Filter -->
            <form method="GET" action="{{ route('transaksi.index') }}" class="form-inline di-flex gap 2">
                <input type="date" name="tanggal_mulai" class="form-control w-auto" value="{{ request('tanggal_mulai') }}">
                <input type="date" name="tanggal_selesai" class="form-control w-auto"
                    value="{{ request('tanggal_selesai') }}">

                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary ">Reset</a>

            </form>

            <!-- Export Dropdown -->
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-download"></i> Export
                </button>
                <div class="dropdown-menu" aria-labelledby="exportDropdown">
                    <a class="dropdown-item" href="#" id="exportExcel">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a class="dropdown-item" href="{{ route('transaksi.exportPDF', ['tanggal_mulai' => request('tanggal_mulai'), 'tanggal_selesai' => request('tanggal_selesai')]) }}" id="exportPDF">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- DataTables -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Daftar Transaksi</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="transaksiTable" width="100%" cellspacing="0">
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
    </div>
@endsection

@push('script')
    <!-- DataTables CSS (Bootstrap 4) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#transaksiTable').DataTable({
                dom: "<'row'<'col-md-6'l><'col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-md-6'i><'col-md-6'p>>",
                buttons: [{
                        extend: 'excelHtml5',
                        className: 'btn btn-success'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary'
                    }
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                pagingType: "simple_numbers", // Hanya menampilkan tombol Previous & Next
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
                }
            });

            // Fungsi Export saat dropdown diklik
            $('#exportExcel').click(function() {
                table.button(0).trigger();
            });

            $('#exportPDF').click(function() {
                table.button(1).trigger();
            });

            $('#exportPrint').click(function() {
                table.button(2).trigger();
            });
        });
    </script>

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
