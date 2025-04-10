@extends('layouts.layout')
@section('title', 'Detail Transaksi')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="d-flex justify-content-center align-items-center" style="margin: 20px;">
                <div class="col-12">
                    <div class="card mb-5">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Informasi Transaksi</h6>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-borderless" style="margin-bottom: 3%">
                                    <tbody>
                                        <tr>
                                            <th style="width: 20%;">Nomor Transaksi</th>
                                            <th>:</th>
                                            <td>{{ $transaksi->nomor_transaksi }}</td>
                                            <th>Tanggal Transaksi</th>
                                            <th>:</th>
                                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Transaksi</th>
                                            <th>:</th>
                                            <td>{{ number_format($transaksi->total) }}</td>
                                            <th>Pembayaran</th>
                                            <th>:</th>
                                            <td>{{ $transaksi->pembayaran }}</td>
                                        </tr>
                                        <tr>
                                            <th>Member</th>
                                            <th>:</th>
                                            <td>{{ $transaksi->member->nama ?? '-' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered" id="datatable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Produk</th>
                                            <th class="text-center">Warna</th>
                                            <th class="text-center">Size</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detailTransaksi as $detail)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $detail->produk->nama ?? 'Produk tidak ditemukan' }}</td>
                                            <td class="text-center">{{ $detail->varian->warna ?? 'Produk tidak ditemukan' }}</td>
                                            <td class="text-center">{{ $detail->varian->size ?? 'Produk tidak ditemukan' }}</td>
                                            <td class="text-center">{{ $detail->qty }}</td>
                                            <td class="text-right">{{ number_format($detail->harga) }}</td>
                                            <td class="text-right">{{ number_format($detail->subtotal) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="mt-4">
                                    <a href="{{ route('transaksi.index') }}" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection