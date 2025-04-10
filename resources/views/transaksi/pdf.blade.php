<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
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
    <h1 class="text-center">Laporan Transaksi</h1>
    <p class="text-center">
        @if ($tanggal_mulai && $tanggal_selesai)
            Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d F Y') }} - {{ \Carbon\Carbon::parse($tanggal_selesai)->format('d F Y') }}
        @else
            Semua Data
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kasir</th>
                <th>Member</th>
                <th>Total</th>
                <th>Metode Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}</td>
                    <td>{{ $item->user->user_nama }}</td>
                    <td>{{ $item->member ? $item->member->nama : '-' }}</td>
                    <td class="text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->pembayaran }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>