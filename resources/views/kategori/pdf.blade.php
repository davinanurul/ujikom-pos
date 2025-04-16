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

        th, td {
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
                <th>No</th>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $kategori)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td style="text-align: left;">{{ $kategori->nama_kategori }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>