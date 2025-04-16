@extends('layouts.layout')
@section('title', 'Member')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fa fa-users text-primary mr-2"></i> Data Member</h4>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAbsensiModal">
                    Tambah Data Absensi
                </button>
                <button class="btn btn-warning text-white" onclick="window.print();">
                    <i class="fa fa-print text-white mr-1"></i>Ekspor
                </button>
                <button type="button" class="btn btn-primary text-white" data-toggle="modal"
                    data-target="#importMemberModal">
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
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Telepon</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Tanggal Bergabung</th>
                                        <th class="text-center" style="width: 20%">Aksi</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="createAbsensiModal" tabindex="-1" aria-labelledby="createAbsensiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createAbsensiModalLabel">Tambah Data Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form untuk tambah data absensi -->
                    <form action="{{ route('absensi.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                            <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_masuk" class="form-label">Waktu Masuk</label>
                            <input type="time" class="form-control" id="waktu_masuk" name="waktu_masuk">
                        </div>
                        <div class="mb-3">
                            <label for="status_masuk" class="form-label">Status Masuk</label>
                            <select class="form-select" id="status_masuk" name="status_masuk" required>
                                <option value="masuk">Masuk</option>
                                <option value="sakit">Sakit</option>
                                <option value="cuti">Cuti</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importMemberModal" tabindex="-1" role="dialog" aria-labelledby="importMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('member.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="importMemberModalLabel">Impor Member dari Excel</h5>
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

    <!-- Bootstrap JS (untuk modal dan interaksi lainnya) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
