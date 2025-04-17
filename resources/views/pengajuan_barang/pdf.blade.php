<!DOCTYPE html>
<html>
<head>
    <title>Export PDF - Pengajuan Barang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Pengajuan Barang</h2>
    <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengaju</th>
                <th>Nama Barang</th>
                <th>Qty</th>
                <th>Tanggal Pengajuan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuans as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_pengaju }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}</td>
                    <td>{{ $item->terpenuhi ? 'Terpenuhi' : 'Belum Terpenuhi' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>