<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produk Varian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <h1 class="text-center">Laporan Produk Varian</h1>
    <p class="text-center">
        @if ($idProduk)
            Produk: {{ \App\Models\Produk::find($idProduk)->nama }}
        @else
            Semua Produk
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Warna</th>
                <th>Size</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Total Terjual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produkVarians as $index => $varian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $varian->produk->nama }}</td>
                    <td>{{ $varian->warna }}</td>
                    <td>{{ $varian->size }}</td>
                    <td class="text-right">Rp {{ number_format($varian->harga_jual, 0, ',', '.') }}</td>
                    <td>{{ $varian->stok }}</td>
                    <td>{{ $varian->detailTransaksi->first()->total_terjual ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>