@extends('layouts.layout')
@section('title', 'Struk Transaksi')

@section('content')
    <style>
        .struk-container {
            max-width: 400px;
            margin: 0 auto;
            font-family: monospace;
            font-size: 14px;
            background-color: #fff;
            padding: 20px;
            border: 1px dashed #000;
        }

        .struk-container h4,
        .struk-container p {
            text-align: center;
            margin: 0;
        }

        .struk-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .struk-table th,
        .struk-table td {
            text-align: left;
            padding: 4px 0;
        }

        .struk-table th {
            font-weight: bold;
        }

        .struk-total {
            border-top: 1px dashed #000;
            margin-top: 10px;
            padding-top: 5px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>

    <div class="struk-container" id="print-area>
        <h4>Nama Toko</h4>
        <p>Jl. Contoh Alamat No. 123</p>
        <p>0812-XXXX-XXXX</p>
        <hr>

        <p>No Transaksi : {{ $transaksi->nomor_transaksi }}</p>
        <p>Tanggal : {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d/m/Y H:i') }}</p>
        <p>Pembayaran : {{ $transaksi->pembayaran }}</p>
        <p>Member : {{ $transaksi->member->nama ?? '-' }}</p>

        <hr>
        <table class="struk-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-right">Sub</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailTransaksi as $detail)
                    <tr>
                        <td>
                            {{ $detail->produk->nama ?? '-' }}<br>
                            {{ $detail->varian->warna ?? '-' }} / {{ $detail->varian->size ?? '-' }}
                            x{{ $detail->qty }}<br>
                            @ Rp{{ number_format($detail->harga) }}
                        </td>
                        <td class="text-right">Rp{{ number_format($detail->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="struk-total text-right">Total: Rp{{ number_format($transaksi->total) }}</p>

        <hr>
        <p class="text-center">Terima kasih telah berbelanja</p>
    </div>
    <div class="mt-4">
        <button onclick="printStruk()" class="btn btn-success">Cetak</button>
    </div>
    
    <script>
        function printStruk() {
            var strukContent = document.querySelector('.struk-container'); // Pilih div struk-container
            var bodyContent = document.body.innerHTML; // Ambil seluruh konten halaman
    
            // Sisipkan hanya konten struk ke dalam body untuk mencetak
            document.body.innerHTML = strukContent.outerHTML;
    
            // Mencetak
            window.print();
    
            // Kembalikan konten body setelah pencetakan selesai
            document.body.innerHTML = bodyContent;
        }
    </script>    
@endsection
