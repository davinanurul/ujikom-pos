@extends('layouts.layout')
@section('title', 'Tambah User')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h4 class="mb-3"><i class="fa fa-users text-primary mr-2"></i> Form Tambah User</h4>
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="form-group">
                        <label for="user_nama" class="form-label">Nama</label>
                        <input type="text" name="user_nama" id="user_nama"
                            class="form-control @error('user_nama') is-invalid @enderror"
                            value="{{ old('user_nama') }}" required maxlength="255">
                        @error('user_nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="user_pass" class="form-label">Password</label>
                        <input type="password" name="user_pass" id="user_pass"
                            class="form-control @error('user_pass') is-invalid @enderror" required minlength="5">
                        @error('user_pass')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Hak Akses -->
                    <div class="form-group">
                        <label for="user_hak" class="form-label">Hak Akses</label>
                        <select class="form-control @error('user_hak') is-invalid @enderror" id="user_hak" name="user_hak" required>
                            <option value="" disabled {{ old('user_hak') ? '' : 'selected' }}>Pilih Role</option>
                            <option value="admin" {{ old('user_hak') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ old('user_hak') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        @error('user_hak')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tombol -->
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary mr-1">Simpan</button>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-primary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

