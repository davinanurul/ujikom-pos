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
    <h2>Daftar Supplier</h2>

    <table>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Nama</th>
                <th style="text-align: center">Kontak</th>
                <th style="text-align: center">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($suppliers as $index => $supplier)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $supplier->nama }}</td>
                    <td class="text-center">{{ $supplier->kontak }}</td>
                    <td class="text-center">{{ $supplier->alamat }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
