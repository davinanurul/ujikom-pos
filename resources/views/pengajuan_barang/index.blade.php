@extends('layouts.layout')
@section('title', 'Pengajuan Barang')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="btn-group">
                <!-- Tombol "Buat Pengajuan Barang" -->
                <button type="button" class="btn btn-primary rounded-0" data-toggle="modal"
                    data-target="#pengajuanBarangModal">
                    <i class="fas fa-plus"></i> Buat Pengajuan
                </button>

                <!-- Dropdown Export -->
                <div class="dropdown">
                    <button class="btn btn-success dropdown-toggle rounded-0" type="button" id="exportDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="exportDropdown">
                        <a class="dropdown-item" href="#" id="exportExcel">
                            <i class="fas fa-file-excel text-success"></i> Export Excel
                        </a>
                        <a class="dropdown-item" href="{{ route('pengajuanBarang.exportPDF') }}" id="exportPDF">
                            <i class="fas fa-file-pdf text-danger"></i> Export PDF
                        </a>
                    </div>
                </div>
            </div>

            <!-- Grup Filter dan Export -->
            <div class="d-flex align-items-center gap-3">
                <!-- Form Filter -->
                <form method="GET" action="{{ route('pengajuanBarang.index') }}" class="form-inline d-flex gap-2">
                    <div class="input-group">
                        <input type="date" name="tanggal_mulai" class="form-control"
                            value="{{ request('tanggal_mulai') }}">
                        <input type="date" name="tanggal_selesai" class="form-control"
                            value="{{ request('tanggal_selesai') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary"></i> Filter</button>
                            <a href="{{ route('pengajuanBarang.index') }}" class="btn btn-secondary"> Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengajuan Barang</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="pengajuanTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Pengaju</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Tgl Pengajuan</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Terpenuhi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pengajuans as $index => $pengajuan)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $pengajuan->nama_pengaju }}</td>
                                    <td class="text-center">{{ $pengajuan->nama_barang }}</td>
                                    <td class="text-center">{{ $pengajuan->tanggal_pengajuan }}</td>
                                    <td class="text-center">{{ $pengajuan->qty }}</td>
                                    <td class="text-center">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input"
                                                id="terpenuhiSwitch{{ $pengajuan->id }}"
                                                {{ $pengajuan->terpenuhi ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="terpenuhiSwitch{{ $pengajuan->id }}"></label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-warning edit-btn" data-id="{{ $pengajuan->id }}"
                                            data-nama="{{ $pengajuan->nama_pengaju }}" data-toggle="modal"
                                            data-target="#editKategoriModal">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-danger delete-btn"
                                            onclick="confirmDelete('{{ $pengajuan->id }}')">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                        <form id="delete-form-{{ $pengajuan->id }}"
                                            action="{{ route('pengajuanBarang.destroy', $pengajuan->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pengajuanBarangModal" tabindex="-1" role="dialog"
        aria-labelledby="pengajuanBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengajuanBarangModalLabel">Tambah Pengajuan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('pengajuanBarang.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_pengaju">Nama Pengaju</label>
                            <select class="form-control" id="nama_pengaju" name="nama_pengaju" required>
                                <option value="" disabled selected>Pilih Nama Pengaju</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->nama }}">{{ $member->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                        </div>
                        <div class="form-group">
                            <label for="qty">Qty</label>
                            <input type="number" class="form-control" id="qty" name="qty" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pengajuan Barang</h5>
                </div>
                <form id="editForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id" value="{{ old('id') }}">

                        <!-- Nama Pengaju -->
                        <div class="form-group">
                            <label for="nama_pengaju">Nama Pengaju</label>
                            <select class="form-control" id="nama_pengaju" name="nama_pengaju" required>
                                <option value="" disabled>Pilih Nama Pengaju</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->nama }}"
                                        {{ old('nama_pengaju') == $member->nama ? 'selected' : '' }}>
                                        {{ $member->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="edit_qty">Qty</label>
                            <input type="number" class="form-control" id="edit_qty" name="qty" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        $(document).ready(function() {
            var table = $('#pengajuanTable').DataTable({
                dom: "<'row'<'col-md-6'l><'col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-md-6'i><'col-md-6'p>>",
                buttons: [{
                        extend: 'excelHtml5',
                        className: 'btn btn-success',
                        title: 'Pengajuan-Barang',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                            format: {
                                body: function(data, row, column, node) {
                                    // Cek kolom ke-5 (index 5) untuk status Terpenuhi
                                    if (column === 5) {
                                        // Cek apakah switch dalam keadaan checked atau tidak
                                        return $(node).find('input[type="checkbox"]').is(
                                            ':checked') ? 'Terpenuhi' : 'Belum Terpenuhi';
                                    }
                                    return data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger',
                        title: 'Pengajuan-Barang',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 5) {
                                        return $(node).find('input[type="checkbox"]').is(
                                            ':checked') ? 'Terpenuhi' : 'Belum Terpenuhi';
                                    }
                                    return data;
                                }
                            }
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary',
                        title: 'Pengajuan-Barang',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 5) {
                                        return $(node).find('input[type="checkbox"]').is(
                                            ':checked') ? 'Terpenuhi' : 'Belum Terpenuhi';
                                    }
                                    return data;
                                }
                            }
                        }
                    }
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                pagingType: "simple_numbers",
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
                }
            });

            // Tombol Export Khusus Tabel Ini
            $('#exportExcel').click(function() {
                table.button(0).trigger();
            });

            $('#exportPDF').click(function() {
                table.button(1).trigger();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                const id = $(this).data('id');
                const namaPengaju = $(this).data('nama');
                const namaBarang = $(this).closest('tr').find('td:eq(2)').text();
                const qty = $(this).closest('tr').find('td:eq(4)').text();

                $('#edit_id').val(id);
                $('#edit_nama_barang').val(namaBarang);
                $('#edit_qty').val(qty);
                $('#editForm').attr('action', `/pengajuan/${id}`);
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

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
        $(document).ready(function() {
            $('.custom-control-input').on('change', function() {
                let pengajuanId = $(this).attr('id').replace('terpenuhiSwitch', '');
                let terpenuhi = $(this).is(':checked') ? 1 : 0;

                $.ajax({
                    url: "/pengajuan/" + pengajuanId + "/update-terpenuhi",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        terpenuhi: terpenuhi
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal memperbarui status.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                });
            });
        });
    </script>
@endpush
