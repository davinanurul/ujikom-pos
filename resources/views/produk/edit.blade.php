@extends('layouts.layout')
@section('title', 'Edit Produk')

@section('content')
    <div class="container-fluid">
        <div class="page-body">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Form Edit Produk</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group mt-0">
                            <label for="kategori_id">Kategori</label>
                            <select name="kategori_id" id="kategori_id" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('kategori_id', $produk->kategori_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-0">
                            <label for="supplier_id">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control" required>
                                <option value="">Pilih Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ old('supplier_id', $produk->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-0">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control"
                                value="{{ old('nama', $produk->nama) }}" required>
                        </div>

                        <div class="form-group mt-0">
                            <label for="gambar" class="form-label">Gambar Produk</label>
                        <div class="custom-file">
                            <input type="file" name="gambar" id="gambar" class="custom-file-input" accept="image/*">
                            <label class="custom-file-label" for="gambar">Pilih Gambar</label>
                        </div>
                            <div class="mt-2">
                                <img id="preview"
                                    src="{{ $produk->gambar ? asset('storage/produk-img/' . $produk->gambar) : 'https://via.placeholder.com/150' }}"
                                    alt="Pratinjau Gambar" width="150">
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('produk.index') }}" class="btn btn-secondary me-1">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        });
    </script>
@endpush