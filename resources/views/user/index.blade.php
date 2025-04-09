@extends('layouts.layout')
@section('title', 'Daftar Pengguna')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fa fa-users text-primary mr-2"></i> Daftar Pengguna</h4>
        <div>
            <a href="{{ route('user.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah User
            </a>
            <button class="btn btn-success" onclick="window.print();">
                <i class="fa fa-print"></i> Print/Ekspor
            </button>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive mb-4">
            <table class="table table-striped table-bordered zero-configuration">
                <thead class="thead-light">
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Nama User</th>
                        <th class="text-center">Hak Akses</th>
                        <th class="text-center">Tanggal Dibuat</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($daftarPengguna as $index => $pengguna)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $pengguna->user_nama }}</td>
                            <td class="text-center">{{ $pengguna->user_hak }}</td>
                            <td class="text-center">{{ $pengguna->created_at }}</td>
                            <td class="text-center">
                                <span class="badge badge-{{ $pengguna->user_sts ? 'success' : 'secondary' }}">
                                    {{ $pengguna->user_sts ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($pengguna->user_sts)
                                    <button class="btn btn-sm btn-danger"
                                        onclick="confirmDeactivation({{ $pengguna->user_id }}, 'nonaktifkan')">
                                        <i class="fas fa-user-slash"></i> Nonaktifkan
                                    </button>
                                @else
                                    <button class="btn btn-sm btn-success"
                                        onclick="confirmDeactivation({{ $pengguna->user_id }}, 'aktifkan')">
                                        <i class="fas fa-user-check"></i> Aktifkan
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
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

    function confirmDeactivation(userId, action) {
        let title, text, confirmButtonText;

        if (action === 'nonaktifkan') {
            title = 'Konfirmasi';
            text = 'Apakah Anda yakin ingin menonaktifkan akun ini?';
            confirmButtonText = 'Ya, Nonaktifkan';
        } else if (action === 'aktifkan') {
            title = 'Konfirmasi';
            text = 'Apakah Anda yakin ingin mengaktifkan akun ini?';
            confirmButtonText = 'Ya, Aktifkan';
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
                if (action === 'nonaktifkan') {
                    window.location.href = '/nonaktifkan-akun/' + userId;
                } else if (action === 'aktifkan') {
                    window.location.href = '/aktifkan-akun/' + userId;
                }
            }
        });
    }
</script>
@endsection