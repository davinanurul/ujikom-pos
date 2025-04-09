@extends('layouts.layout')
@section('title', 'Member')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0"><i class="fa fa-users text-primary mr-2"></i> Data Member</h4>
        <div>
            <a href="{{ route('member.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Tambah Member
            </a>
            <button class="btn btn-success" onclick="window.print();">
                <i class="fa fa-print"></i> Print/Ekspor
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
                                    <th class="text-center">Status</th>
                                    <th class="text-center" style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($members as $index => $member)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="text-center">{{ $member->nama }}</td>
                                        <td class="text-center">{{ $member->telepon }}</td>
                                        <td class="text-center">{{ $member->alamat }}</td>
                                        <td class="text-center">{{ $member->tanggal_bergabung }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $member->status == 'aktif' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ ucfirst($member->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('member.edit', $member->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            @if ($member->status == 'aktif')
                                                <a href="{{ route('member.nonaktifkan', $member->id) }}" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-times"></i> Nonaktifkan
                                                </a>
                                            @else
                                                <a href="{{ route('member.aktifkan', $member->id) }}" class="btn btn-sm btn-success">
                                                    <i class="fa fa-check"></i> Aktifkan
                                                </a>
                                            @endif
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
