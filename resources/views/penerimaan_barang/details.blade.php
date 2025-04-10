@extends('layouts.layout')
@section('title', 'Detail Penerimaan Barang')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="d-flex justify-content-center align-items-center" style="margin: 20px;">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Penerimaan Barang</h6>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered" style="margin-bottom: 3%">
                                    <tbody>
                                        <tr>
                                            <th>Tanggal Penerimaan</th>
                                            <th>:</th>
                                            <td>{{ \Carbon\Carbon::parse($penerimaan->created_at)->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penerima</th>
                                            <th>:</th>
                                            <td>{{ $penerimaan->user->user_nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nama Supplier</th>
                                            <th>:</th>
                                            <td>{{ $penerimaan->supplier->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat Supplier</th>
                                            <th>:</th>
                                            <td>{{ $penerimaan->supplier->alamat ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nama Produk</th>
                                            <th class="text-center">Warna</th>
                                            <th class="text-center">Size</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Harga Beli</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">{{ $penerimaan->produk->nama ?? 'Produk tidak ditemukan' }}</td>
                                            <td class="text-center">{{ $penerimaan->varian->warna ?? 'Produk tidak ditemukan' }}</td>
                                            <td class="text-center">{{ $penerimaan->varian->size ?? 'Produk tidak ditemukan' }}</td>
                                            <td class="text-center">{{ $penerimaan->qty }}</td>
                                            <td class="text-center">{{ number_format($penerimaan->harga_beli) }}</td>
                                            <td class="text-center">{{ number_format($penerimaan->harga_beli * $penerimaan->qty) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="mt-4">
                                    <a href="{{ route('penerimaan_barang.index') }}" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection