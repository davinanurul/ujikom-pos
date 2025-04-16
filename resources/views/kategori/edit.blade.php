@extends('layouts.layout')
@section('title', 'Edit Kategori')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h4 class="mb-3"><i class="fa fa-users text-primary mr-2"></i> Form Edit Kategori</h4>
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori"
                                value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn mb-1 btn-outline-primary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn mb-1 btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
