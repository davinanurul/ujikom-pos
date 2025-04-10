@extends('layouts.layout')
@section('title', 'Tambah Varian Produk')
@section('content')
<div class="container-fluid">
    <div class="page-body">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Form Tambah Varian Produk</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('produk_varian.store')}}" method="POST">
                    @csrf
                    <div class="form-group mt-0">
                        <label for="id_produk">Nama Produk</label>
                        <select name="id_produk" id="id_produk" class="form-control" required>
                            <option value="">Pilih Produk</option>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-0">
                        <label for="size">Ukuran</label>
                        <select class="form-control @error('size') is-invalid @enderror" id="size" name="size"
                            required>
                            <option value="" disabled {{ old('size') ? '' : 'selected' }}>Pilih Ukuran</option>
                            <option value="S" {{ old('size') == 'S' ? 'selected' : '' }}>S</option>
                            <option value="M" {{ old('size') == 'M' ? 'selected' : '' }}>M</option>
                            <option value="L" {{ old('size') == 'L' ? 'selected' : '' }}>L</option>
                            <option value="XL" {{ old('size') == 'XL' ? 'selected' : '' }}>XL</option>
                        </select>
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-0">
                        <label for="warna">Warna</label>
                        <input type="text" name="warna" id="warna" class="form-control" required>
                    </div>
                    <div class="form-group mt-0">
                        <label for="harga_jual">Harga</label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control" required>
                    </div>
                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('produk_varian.index') }}" class="btn btn-secondary me-1">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
