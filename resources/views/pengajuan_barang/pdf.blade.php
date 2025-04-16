<!DOCTYPE html>
<html>

<head>
    <title>Daftar Pengajuan Barang</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            margin: 20px;
        }

        h2 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            font-size: 15px;
        }

        td {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <h2>Daftar Pengajuan Barang</h2>

    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Nama Pengaju</th>
                <th style="text-align: center">Nama Barang</th>
                <th style="text-align: center">Tanggal Pengajuan</th>
                <th style="text-align: center">Qty</th>
                <th style="text-align: center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengajuans as $index => $pengajuan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $pengajuan->nama_pengaju }}</td>
                    <td class="text-center">{{ $pengajuan->nama_barang }}</td>
                    <td class="text-center">{{ $pengajuan->tanggal_pengajuan }}</td>
                    <td class="text-center">{{ $pengajuan->qty }}</td>
                    <td class="text-center">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="terpenuhiSwitch{{ $pengajuan->id }}"
                                {{ $pengajuan->terpenuhi ? 'checked' : '' }}>
                            <label class="custom-control-label" for="terpenuhiSwitch{{ $pengajuan->id }}"></label>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
