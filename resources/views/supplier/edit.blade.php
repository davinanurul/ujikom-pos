@extends('layouts.layout')
@section('title', 'Edit Supplier')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h3 class="mb-3"><i class="fa fa-truck text-primary mr-2"></i> Form Edit Supplier</h3>
                <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mt-0">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama', $supplier->nama) }}"
                            class="form-control" required>
                    </div>
                    <div class="form-group mt-0">
                        <label for="kontak">Kontak</label>
                        <input type="number" name="kontak" id="kontak"
                            value="{{ old('kontak', $supplier->kontak) }}" class="form-control" required>
                    </div>
                    <div class="form-group mt-0">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat"
                            value="{{ old('alamat', $supplier->alamat) }}" class="form-control" required>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('supplier.index') }}" class="btn btn-secondary me-1">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
