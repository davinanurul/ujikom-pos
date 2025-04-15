@extends('layouts.layout')
@section('title', 'Edit Member')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <h4 class="mb-3"><i class="fa fa-users text-primary mr-2"></i> Form Edit Member</h4>
                <form action="{{ route('member.update', $member->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group mt-0">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ $member->nama }}" required>
                    </div>
                    <div class="form-group mt-0">
                        <label for="telepon">Telepon</label>
                        <input type="number" name="telepon" id="telepon" class="form-control"
                            value="{{ $member->telepon }}" required>
                    </div>
                    <div class="form-group mt-0">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" id="alamat" class="form-control"
                            value="{{ $member->alamat }}" required>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary mr-1">Simpan</button>
                        <a href="{{ route('member.index') }}" class="btn btn-outline-primary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
