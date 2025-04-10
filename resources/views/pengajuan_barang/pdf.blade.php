<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Barang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center">Laporan Pengajuan Barang</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Pengaju</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuans as $pengajuan)
                <tr>
                    <td>{{ $pengajuan->nama_pengaju }}</td>
                    <td>{{ $pengajuan->nama_barang }}</td>
                    <td>{{ $pengajuan->qty }}</td>
                    <td>{{ $pengajuan->tanggal_pengajuan }}</td>
                    <td>{{ $pengajuan->terpenuhi ? 'Terpenuhi' : 'Belum Terpenuhi' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
