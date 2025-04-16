<!DOCTYPE html>
<html>

<head>
    <title>Daftar Kategori Produk</title>
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
    <h2>Daftar Kategori Produk</h2>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%">No</th>
                <th class="text-center">Nama</th>
                <th class="text-center">Telepon</th>
                <th class="text-center">Alamat</th>
                <th class="text-center">Tanggal Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $index => $member)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $member->nama }}</td>
                    <td class="text-center">{{ $member->telepon }}</td>
                    <td class="text-center" style="width: 30%">{{ $member->alamat }}</td>
                    <td class="text-center">{{ $member->tanggal_bergabung }}</td>
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
