@extends('layouts.layout')
@section('title', 'Absensi Kerja')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fa fa-tags text-primary mr-2"></i> Absensi Kerja</h4>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createAbsensiModal">
                    <i class="fa fa-plus mr-1"></i> Tambah
                </button>
                <a href="{{ route('absen.export.pdf') }}" class="btn btn-danger">
                    <i class="fa fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('absensi.export') }}" class="btn btn-success">
                    <i class="fa fa-file-excel"></i> Export Excel
                </a>
                <button type="button" class="btn btn-primary text-white" data-toggle="modal"
                    data-target="#importAbsenKerjaModal">
                    <i class="fa fa-file mr-1"></i> Impor
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div>
                        <div class="table-responsive mb-5">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 8%">No</th>
                                        <th class="text-center">Nama Karyawan</th>
                                        <th class="text-center">Tanggal Masuk</th>
                                        <th class="text-center">Waktu Masuk</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Waktu Selesai</th>
                                        <th class="text-center">Update Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($absensi as $index => $absensi)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $absensi->nama_karyawan }}</td>
                                            <td class="text-center">{{ $absensi->tanggal_masuk }}</td>
                                            <td class="text-center">{{ $absensi->waktu_masuk }}</td>
                                            <td class="text-center">{{ $absensi->status_masuk }}</td>
                                            <td class="text-center">
                                                @if ($absensi->waktu_selesai_kerja)
                                                    {{ $absensi->waktu_selesai_kerja }}
                                                @else
                                                    <button class="btn btn-sm btn-primary"
                                                        onclick="updateWaktuSelesai({{ $absensi->id }})">Selesai</button>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <form action="{{ route('absen.update.status', $absensi->id) }}"
                                                    method="POST" class="update-status-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="basic-form mb-0">
                                                        <div class="form-row align-items-center">
                                                            <div class="col-auto my-1">
                                                                <select name="status_masuk" class="custom-select mr-sm-2"
                                                                    onchange="this.form.submit()" style="width: 60px;">
                                                                    <option value="masuk"
                                                                        {{ $absensi->status_masuk == 'masuk' ? 'selected' : '' }}>
                                                                        Masuk</option>
                                                                    <option value="sakit"
                                                                        {{ $absensi->status_masuk == 'sakit' ? 'selected' : '' }}>
                                                                        Sakit</option>
                                                                    <option value="cuti"
                                                                        {{ $absensi->status_masuk == 'cuti' ? 'selected' : '' }}>
                                                                        Cuti</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton{{ $absensi->id }}" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Aksi
                                                    </button>
                                                    <div class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton{{ $absensi->id }}">
                                                        <a class="dropdown-item text-success" href="#"
                                                            data-toggle="modal"
                                                            data-target="#editAbsensiModal{{ $absensi->id }}">
                                                            <i class="fa fa-edit mr-1"></i> Edit
                                                        </a>
                                                        <form action="{{ route('absen.destroy', $absensi->id) }}"
                                                            method="POST" onsubmit="return confirmDelete(event);">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fa fa-trash mr-1"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit Data -->
                                        <div class="modal fade" id="editAbsensiModal{{ $absensi->id }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Data Absensi Kerja</h5>
                                                    </div>
                                                    <form action="{{ route('absen.update', $absensi->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Nama Karyawan</label>
                                                                <input type="text" class="form-control"
                                                                    name="nama_karyawan"
                                                                    value="{{ old('nama_karyawan', $absensi->nama_karyawan) }}"
                                                                    required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Tanggal Masuk</label>
                                                                <input type="date" class="form-control"
                                                                    name="tanggal_masuk"
                                                                    value="{{ old('tanggal_masuk', $absensi->tanggal_masuk) }}"
                                                                    required>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Waktu Masuk</label>
                                                                <input type="time" class="form-control"
                                                                    name="waktu_masuk"
                                                                    value="{{ old('waktu_masuk', $absensi->waktu_masuk) }}">
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Status Masuk</label>
                                                                <select name="status_masuk" class="form-control" required>
                                                                    <option value="masuk"
                                                                        {{ old('status_masuk', $absensi->status_masuk) == 'masuk' ? 'selected' : '' }}>
                                                                        Masuk</option>
                                                                    <option value="sakit"
                                                                        {{ old('status_masuk', $absensi->status_masuk) == 'sakit' ? 'selected' : '' }}>
                                                                        Sakit</option>
                                                                    <option value="cuti"
                                                                        {{ old('status_masuk', $absensi->status_masuk) == 'cuti' ? 'selected' : '' }}>
                                                                        Cuti</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light"
                                                                data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan
                                                                Perubahan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="createAbsensiModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Absensi Kerja</h5>
                </div>
                <form action="{{ route('absen.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Karyawan</label>
                            <input type="text" class="form-control" name="nama_karyawan" required>
                        </div>

                        <div class="form-group">
                            <label>Tanggal Masuk</label>
                            <input type="date" class="form-control" name="tanggal_masuk" required>
                        </div>

                        <div class="form-group">
                            <label>Waktu Masuk</label>
                            <input type="time" class="form-control" name="waktu_masuk">
                        </div>

                        <div class="form-group">
                            <label>Status Masuk</label>
                            <select name="status_masuk" class="form-control" required>
                                <option value="masuk">Masuk</option>
                                <option value="sakit">Sakit</option>
                                <option value="cuti">Cuti</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <!-- Modal Import Excel -->
    <div class="modal fade" id="importAbsenKerjaModal" tabindex="-1" role="dialog"
        aria-labelledby="importAbsenKerjaModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('absen.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importMemberModalLabel">Impor Data Absensi dari Excel</h5>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nama_kategori').value = nama;
                document.getElementById('editForm').action = `/kategori/${id}`;
            });
        });

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

        $(document).on('click', '.edit-btn', function() {
            var absensiId = $(this).data('id'); // Ambil ID absensi dari tombol

            // Mengambil data absensi melalui Ajax
            $.ajax({
                url: '/absensi/' + absensiId + '/edit', // Sesuaikan dengan route yang sesuai
                type: 'GET',
                success: function(data) {
                    // Isi form modal dengan data yang diterima
                    $('#editAbsensiModal' + absensiId + ' form').attr('action', '/absensi/' +
                        absensiId); // Update action form dengan ID yang benar
                    $('#editAbsensiModal' + absensiId + ' #nama_karyawan').val(data.absensi
                        .nama_karyawan); // Mengisi Nama Karyawan
                    $('#editAbsensiModal' + absensiId + ' #tanggal_masuk').val(data.absensi
                        .tanggal_masuk); // Mengisi Tanggal Masuk
                    $('#editAbsensiModal' + absensiId + ' #waktu_masuk').val(data.absensi
                        .waktu_masuk); // Mengisi Waktu Masuk
                    $('#editAbsensiModal' + absensiId + ' #status_masuk').val(data.absensi
                        .status_masuk); // Mengisi Status Masuk
                    $('#editAbsensiModal' + absensiId).modal('show'); // Tampilkan modal
                },
                error: function() {
                    alert('Error retrieving data.');
                }
            });
        });
    </script>

    <script>
        function confirmDelete(event) {
            event.preventDefault(); // Mencegah form submit langsung

            // Menampilkan konfirmasi SweetAlert
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Data yang dihapus tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user konfirmasi, kirim form untuk menghapus
                    event.target.closest('form').submit();
                }
            });
        }
    </script>
    <script>
        function updateWaktuSelesai(id) {
            Swal.fire({
                title: 'Yakin ingin menyelesaikan?',
                text: "Data akan diperbarui dengan waktu sekarang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, update sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/absensi/' + id + '/update-waktu-selesai',
                        method: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            waktu_selesai: new Date().toISOString()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Waktu selesai telah diperbarui.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire(
                                'Gagal!',
                                'Terjadi kesalahan saat memperbarui data.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endsection
