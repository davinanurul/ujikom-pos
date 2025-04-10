@extends('layouts.layout')
@section('title', 'Data Penerimaan Barang')
@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold">Form Data Penerimaan Barang</h6>
            </div>
            <div class="card-body">
                <form action="{{{ route('penerimaan_barang.store')}}}" method="POST">
                    @csrf
                    <div class="form-group mt-0">
                        <label for="id_supplier">Supplier</label>
                        <select name="id_supplier" id="id_supplier" class="form-control" required>
                            <option value="">Pilih Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-0">
                        <label for="id_produk">Produk</label>
                        <select name="id_produk" id="id_produk" class="form-control" required>
                            <option value="">Pilih Produk</option>
                        </select>
                    </div>

                    <div class="form-group mt-0">
                        <label for="id_varian">Varian Produk</label>
                        <select name="id_varian" id="id_varian" class="form-control" required>
                            <option value="">Pilih Varian</option>
                        </select>
                    </div>

                    <div class="form-group mt-0">
                        <label for="qty">Qty</label>
                        <input type="number" name="qty" id="qty" class="form-control" required>
                    </div>

                    <div class="form-group mt-0">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" required>
                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('penerimaan_barang.index') }}" class="btn btn-secondary me-1">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Tambahkan Script untuk AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#id_supplier').change(function() {
                var supplierId = $(this).val();
                $('#id_produk').html('<option value="">Loading...</option>');

                if (supplierId) {
                    $.ajax({
                        url: '/penerimaan-barang/get-produk/' + supplierId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#id_produk').html('<option value="">Pilih Produk</option>');
                            $.each(data, function(key, value) {
                                $('#id_produk').append('<option value="' + value.id +
                                    '">' + value.nama + '</option>');
                            });
                        }
                    });
                } else {
                    $('#id_produk').html('<option value="">Pilih Produk</option>');
                }
            });
        });

        $(document).ready(function() {
            $('#id_produk').change(function() {
                var produkId = $(this).val();
                $('#id_varian').html('<option value="">Loading...</option>');

                if (produkId) {
                    $.ajax({
                        url: '/penerimaan-barang/get-varian/' + produkId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#id_varian').html('<option value="">Pilih Varian</option>');
                            $.each(data, function(key, value) {
                                $('#id_varian').append('<option value="' + value.id +
                                    '">' + value.size + ' - ' + value.warna +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#id_varian').html('<option value="">Pilih Varian</option>');
                }
            });
        });
    </script>
@endsection
