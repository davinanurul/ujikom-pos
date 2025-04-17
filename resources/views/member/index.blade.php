@extends('layouts.layout')
@section('title', 'Member')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fa fa-users text-primary mr-2"></i> Data Member</h4>
            <div>
                <a href="{{ route('member.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus mr-1"></i> Tambah
                </a>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-download text-white mr-1"></i> Ekspor Excel
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('member.export.excel') }}"">
                            Export Excel
                        </a>                        
                        <a class="dropdown-item" href="{{ route('member.export.pdf') }}">
                            Ekspor PDF
                        </a>                        
                    </div>
                </div>     
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
                                <tbody>
                                    @forelse ($members as $index => $member)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $member->nama }}</td>
                                            <td class="text-center">{{ $member->telepon }}</td>
                                            <td class="text-center" style="width: 30%">{{ $member->alamat }}</td>
                                            <td class="text-center">{{ $member->tanggal_bergabung }}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group" aria-label="Aksi Member">
                                                    <a href="{{ route('member.edit', $member->id) }}"
                                                        class="btn btn-sm btn-success text-white">
                                                        <i class="fa fa-edit text-white"></i> Edit
                                                    </a>

                                                    @if ($member->status == 'aktif')
                                                        <button
                                                            onclick="confirmDeactivation({{ $member->id }}, 'nonaktifkan')"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="fa fa-times"></i> Nonaktifkan
                                                        </button>
                                                    @else
                                                        <button
                                                            onclick="confirmDeactivation({{ $member->id }}, 'aktifkan')"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fa fa-check"></i> Aktifkan
                                                        </button>
                                                    @endif
                                                </div>
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
        </div>
    </div>

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importMemberModal" tabindex="-1" role="dialog"
        aria-labelledby="importMemberModalLabel" aria-hidden="true">
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

        function confirmDeactivation(memberId, action) {
            let title, text, confirmButtonText, url;

            if (action === 'nonaktifkan') {
                title = 'Konfirmasi';
                text = 'Apakah Anda yakin ingin menonaktifkan member ini?';
                confirmButtonText = 'Ya, Nonaktifkan';
                url = `/nonaktifkan-member/${memberId}`;
            } else if (action === 'aktifkan') {
                title = 'Konfirmasi';
                text = 'Apakah Anda yakin ingin mengaktifkan member ini?';
                confirmButtonText = 'Ya, Aktifkan';
                url = `/aktifkan-member/${memberId}`;
            }

            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>

@endsection
