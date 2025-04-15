@extends('layouts.layout')

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Transaksi</h6>
            </div>
            <div class="card-body">
                <form id="transaksiForm" action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    <div class="table table-borderless">
                        <table style="width: 100%">
                            <tr>
                                <td style="width: 10%">Tanggal</td>
                                <td style="width: 5%">:</td>
                                <td><span
                                        class="border px-2 py-1 rounded bg-light d-inline-block">{{ now()->format('d F Y') }}</span>
                                </td>
                                <td style="width: 20%; text-align:end">Member (Opsional)</td>
                                <td style="width: 5%">:</td>
                                <td style="width: 20%">
                                    <select class="form-control" id="member_id" name="member_id">
                                        <option value="">Pilih Member</option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Kasir</td>
                                <td>:</td>
                                <td><span
                                        class="border px-2 py-1 rounded bg-light d-inline-block">{{ Auth::user()->user_nama }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <button type="button" class="btn btn-success btn-sm mb-3" onclick="addprodukRow()">+ Tambah
                        Produk</button>
                    {{-- <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal"
                        data-bs-target="#produkModal">Pilih Produk</button> --}}
                    <button type="button" class="btn btn-primary btn-sm mb-3" data-toggle="modal"
                        data-target="#produkModal">
                        Pilih Produk
                    </button>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="produkTable">
                            <thead>
                                <tr>
                                    <th style="width: 20%">Produk</th>
                                    <th style="width: 15%">Warna</th>
                                    <th style="width: 10%">Size</th>
                                    <th>Harga</th>
                                    <th style="width: 10%">Qty</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris pertama (default) -->
                                <tr>
                                    <td>
                                        <input type="text" class="form-control id_produk" name="id_produk[]" readonly>
                                        <input type="hidden" class="form-control produk_id" name="produk_id[]" readonly>
                                        <!-- Tambahkan input hidden untuk produk_id -->
                                    </td>
                                    <td>
                                        <select class="form-control warna-select" name="warna[]" required>
                                            <option value="" disabled selected>-</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select class="form-control size-select" name="size[]" required>
                                            <option value="" disabled selected>-</option>
                                        </select>
                                    </td>
                                    <input type="hidden" class="form-control id_varian" name="id_varian[]" readonly>
                                    <td><input type="text" class="form-control harga" name="harga[]" readonly></td>
                                    <td><input type="number" name="qty[]" class="form-control quantity" min="1"
                                            value="1" oninput="calculateTotal(this)" required></td>
                                    <td><input name="subtotal[]" type="text" class="form-control total" readonly></td>
                                    <td><button type="button" class="btn btn-danger btn-sm remove-row"
                                            onclick="removeRow(this)">Hapus</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label>Total Keseluruhan</label>
                        <input type="text" id="grand_total" name="total" class="form-control bg-light" readonly>
                    </div>
                    <div class="form-group">
                        <label for="pembayaran" class="form-label">Metode Pembayaran</label>
                        <select class="form-control" id="pembayaran" name="pembayaran" required>
                            <option value="TUNAI">TUNAI</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="addKategoriModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Baru</h5>
                </div>
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn mb-1 btn-outline-primary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn mb-1 btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="addKategoriModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Baru</h5>
                </div>
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_kategori" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn mb-1 btn-outline-primary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn mb-1 btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="produkModal" tabindex="-1" aria-labelledby="produkModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="produkModalLabel">Pilih Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input Pencarian -->
                    <div class="mb-3">
                        <input type="text" id="searchProduk" class="form-control" placeholder="Cari produk...">
                    </div>

                    <!-- Daftar Produk dalam Card -->
                    <div class="row row-cols-1 row-cols-md-4 g-4" id="produkList">
                        @foreach ($produks as $produk)
                            <div class="col produk-item">
                                <div class="card h-100">
                                    <img src="{{ asset('/storage/produk-img/' . $produk->gambar) }}" class="card-img-top"
                                        alt="{{ $produk->nama }}" style="height: 200px; object-fit: cover;">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">{{ $produk->nama }}</h6>
                                        <button type="button" class="btn btn-primary btn-block buy-button"
                                            data-id="{{ $produk->id }}" data-name="{{ $produk->nama }}"
                                            data-bs-dismiss="modal">Pilih</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation" class="mt-3">
                        <ul class="pagination justify-content-center" id="pagination">
                            <!-- Pagination akan diisi oleh JavaScript -->
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- DataTables JavaScript -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let activeRow = null;

        document.addEventListener('DOMContentLoaded', function() {
            const buyButtons = document.querySelectorAll('.buy-button');

            buyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const produkId = this.getAttribute('data-id');
                    const produkName = this.getAttribute('data-name');

                    // Jika tidak ada baris aktif, gunakan baris pertama (default)
                    if (!activeRow) {
                        activeRow = document.querySelector("#produkTable tbody tr");
                    }

                    if (activeRow) {
                        const idProdukInput = activeRow.querySelector('.id_produk');
                        idProdukInput.value = produkName;

                        const produkIdInput = activeRow.querySelector(
                            '.produk_id'); // Isi input hidden produk_id
                        produkIdInput.value = produkId;

                        const hiddenInput = activeRow.querySelector('.id_varian');
                        hiddenInput.value = produkId;

                        // Ambil daftar warna berdasarkan produk yang dipilih
                        fetch(`/get-varians/${produkId}`)
                            .then(response => response.json())
                            .then(data => {
                                const warnaDropdown = activeRow.querySelector('.warna-select');
                                warnaDropdown.innerHTML =
                                    '<option value="" disabled selected>-</option>';
                                data.warna.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.warna;
                                    option.textContent = item.warna;
                                    warnaDropdown.appendChild(option);
                                });
                            });
                    }
                });
            });

            // Event listener untuk perubahan dropdown warna
            document.addEventListener('change', function(event) {
                if (event.target.classList.contains('warna-select')) {
                    const row = event.target.closest('tr');
                    const produkId = row.querySelector('.id_varian').value;
                    const warna = event.target.value;

                    if (produkId && warna) {
                        // Ambil daftar size berdasarkan produk dan warna
                        fetch(`/get-sizes/${produkId}/${warna}`)
                            .then(response => response.json())
                            .then(data => {
                                const sizeDropdown = row.querySelector('.size-select');
                                sizeDropdown.innerHTML =
                                    '<option value="" disabled selected>-</option>';
                                data.sizes.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.size;
                                    option.textContent = item.size;
                                    sizeDropdown.appendChild(option);
                                });
                            });
                    }
                }
            });

            // Event listener untuk perubahan dropdown size
            document.addEventListener('change', function(event) {
                if (event.target.classList.contains('size-select')) {
                    const row = event.target.closest('tr');
                    const produkId = row.querySelector('.id_varian').value;
                    const warna = row.querySelector('.warna-select').value;
                    const size = event.target.value;

                    if (produkId && warna && size) {
                        // Ambil harga berdasarkan produk, warna, dan size
                        fetch(`/get-harga/${produkId}/${warna}/${size}`)
                            .then(response => response.json())
                            .then(data => {
                                const hargaInput = row.querySelector('.harga');
                                hargaInput.value = formatRupiah(data.harga);
                                calculateTotal(row.querySelector('.quantity'));
                            });
                    }
                }
            });
        });

        function setActiveRow(row) {
            activeRow = row;
        }

        // Fungsi untuk format Rupiah
        function formatRupiah(angka) {
            return "Rp. " + angka.toLocaleString("id-ID");
        }

        function addprodukRow() {
            const table = document.getElementById("produkTable").getElementsByTagName('tbody')[0];
            const newRow = table.insertRow();
            newRow.innerHTML = `
                <td>
                    <input type="text" class="form-control id_produk" name="id_produk[]" readonly>
                    <input type="hidden" class="form-control produk_id" name="produk_id[]" readonly> <!-- Tambahkan input hidden untuk produk_id -->
                </td>
                <td>
                    <select class="form-control warna-select" name="warna[]" required>
                        <option value="" disabled selected>-</option>
                    </select>
                </td>
                <td>
                    <select class="form-control size-select" name="size[]" required>
                        <option value="" disabled selected>-</option>
                    </select>
                </td>
                <input type="hidden" class="form-control id_varian" name="id_varian[]" readonly>
                <td><input type="text" class="form-control harga" name="harga[]" readonly></td>
                <td><input type="number" name="qty[]" class="form-control quantity" min="1" value="1" oninput="calculateTotal(this)" required></td>
                <td><input name="subtotal[]" type="text" class="form-control total" readonly></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-row" onclick="removeRow(this)">Hapus</button></td>
            `;

            setActiveRow(newRow);
        }

        function removeRow(button) {
            const row = button.closest("tr");
            if (row === activeRow) {
                activeRow = null;
            }
            row.remove();
            calculateGrandTotal();
        }

        function calculateTotal(input) {
            const row = input.closest("tr");
            const hargaInput = row.querySelector(".harga").value.replace(/\D/g, "");
            const harga = parseInt(hargaInput) || 0;
            const quantity = parseInt(row.querySelector(".quantity").value) || 1;
            const total = harga * quantity;

            row.querySelector(".total").value = formatRupiah(total);
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            const totalFields = document.querySelectorAll(".total");
            let grandTotal = 0;

            totalFields.forEach(field => {
                const totalValue = field.value.replace(/\D/g, "");
                grandTotal += parseInt(totalValue) || 0;
            });

            document.getElementById("grand_total").value = formatRupiah(grandTotal);
        }

        $(document).ready(function() {
            const produkItems = $('.produk-item'); // Ambil semua item produk
            const itemsPerPage = 8; // Jumlah item per halaman
            let currentPage = 1; // Halaman saat ini

            // Fungsi untuk menampilkan produk berdasarkan halaman
            function showPage(page) {
                produkItems.hide(); // Sembunyikan semua produk
                produkItems.slice((page - 1) * itemsPerPage, page * itemsPerPage)
                    .show(); // Tampilkan produk untuk halaman tertentu
            }

            // Fungsi untuk mengupdate pagination
            function updatePagination() {
                const totalPages = Math.ceil(produkItems.length / itemsPerPage);
                let paginationHtml = '';

                for (let i = 1; i <= totalPages; i++) {
                    paginationHtml += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#">${i}</a>
                </li>
            `;
                }

                $('#pagination').html(paginationHtml);
            }

            // Fungsi untuk mereset pencarian dan pagination
            function resetSearchAndPagination() {
                $('#searchProduk').val(''); // Reset input pencarian
                produkItems.show(); // Tampilkan semua produk
                currentPage = 1; // Kembali ke halaman pertama
                showPage(currentPage); // Tampilkan halaman pertama
                updatePagination(); // Update pagination
            }

            // Tampilkan halaman pertama saat modal dibuka
            showPage(currentPage);
            updatePagination();

            // Event listener untuk pagination
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                currentPage = parseInt($(this).text());
                showPage(currentPage);
                updatePagination();
            });

            // Event listener untuk pencarian
            $('#searchProduk').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();

                produkItems.each(function() {
                    const produkName = $(this).find('.card-title').text().toLowerCase();
                    if (produkName.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                // Reset pagination setelah pencarian
                currentPage = 1;
                updatePagination();
            });

            // Event listener untuk tombol "Pilih"
            $(document).on('click', '.buy-button', function() {
                const produkId = $(this).data('id');
                const produkName = $(this).data('name');

                if (!activeRow) {
                    activeRow = document.querySelector("#produkTable tbody tr");
                }

                if (activeRow) {
                    const idProdukInput = activeRow.querySelector('.id_produk');
                    idProdukInput.value = produkName;

                    const produkIdInput = activeRow.querySelector('.produk_id');
                    produkIdInput.value = produkId;

                    const hiddenInput = activeRow.querySelector('.id_varian');
                    hiddenInput.value = produkId;

                    // Ambil daftar warna berdasarkan produk yang dipilih
                    fetch(`/get-varians/${produkId}`)
                        .then(response => response.json())
                        .then(data => {
                            const warnaDropdown = activeRow.querySelector('.warna-select');
                            warnaDropdown.innerHTML = '<option value="" disabled selected>-</option>';
                            data.warna.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.warna;
                                option.textContent = item.warna;
                                warnaDropdown.appendChild(option);
                            });
                        });
                }
            });

            // Event listener untuk modal close
            $('#produkModal').on('hidden.bs.modal', function() {
                resetSearchAndPagination(); // Reset pencarian dan pagination saat modal ditutup
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables
            $('#produkTableModal').DataTable({
                "paging": true, // Aktifkan pagination
                "searching": true, // Aktifkan fitur pencarian
                "ordering": true, // Aktifkan sorting
                "info": true, // Tampilkan informasi jumlah data
                "language": {
                    "search": "Cari:", // Ubah teks placeholder pencarian
                    "paginate": {
                        "previous": "Sebelumnya",
                        "next": "Selanjutnya"
                    }
                }
            });

            // Event listener untuk tombol "Pilih"
            $(document).on('click', '.buy-button', function() {
                const produkId = $(this).data('id');
                const produkName = $(this).data('name');

                if (!activeRow) {
                    activeRow = document.querySelector("#produkTable tbody tr");
                }

                if (activeRow) {
                    const idProdukInput = activeRow.querySelector('.id_produk');
                    idProdukInput.value = produkName;

                    const produkIdInput = activeRow.querySelector('.produk_id');
                    produkIdInput.value = produkId;

                    const hiddenInput = activeRow.querySelector('.id_varian');
                    hiddenInput.value = produkId;

                    // Ambil daftar warna berdasarkan produk yang dipilih
                    fetch(`/get-varians/${produkId}`)
                        .then(response => response.json())
                        .then(data => {
                            const warnaDropdown = activeRow.querySelector('.warna-select');
                            warnaDropdown.innerHTML = '<option value="" disabled selected>-</option>';
                            data.warna.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.warna;
                                option.textContent = item.warna;
                                warnaDropdown.appendChild(option);
                            });
                        });
                }
            });
        });

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nama_kategori').value = nama;
                document.getElementById('editForm').action = `/kategori/${id}`;
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: {!! json_encode(session('success')) !!}
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: {!! json_encode(session('error')) !!}
                });
            @endif
        });
    </script>
    <script>
        document.getElementById('transaksiForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch("{{ route('transaksi.store') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            title: 'Transaksi Berhasil!',
                            text: 'Apa yang ingin Anda lakukan selanjutnya?',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonText: 'Cetak Struk',
                            cancelButtonText: 'Tutup',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`/struk/${data.transaksi_id}?ajax=true`, {
                                        headers: {
                                            'X-Requested-With': 'XMLHttpRequest'
                                        }
                                    })
                                    .then(res => res.text())
                                    .then(html => {
                                        if (!html.trim()) {
                                            Swal.fire('Gagal Cetak',
                                                'Struk kosong atau tidak ditemukan.', 'error');
                                            return;
                                        }

                                        const printWindow = window.open('', '_blank');
                                        printWindow.document.open();
                                        printWindow.document.write(`
                                    <html>
                                        <head>
                                            <title>Struk Transaksi</title>
                                            <style>
                                                body { font-family: sans-serif; padding: 20px; }
                                            </style>
                                        </head>
                                        <body onload="window.print(); window.close();">
                                            ${html}
                                        </body>
                                    </html>
                                `);
                                        printWindow.document.close();

                                        // Cek apakah jendela sudah ditutup
                                        const checkWindow = setInterval(() => {
                                            if (printWindow.closed) {
                                                clearInterval(checkWindow);
                                                window.location.href =
                                                    "{{ route('transaksi.create') }}";
                                            }
                                        }, 500);
                                    });
                            } else {
                                window.location.href = "{{ route('transaksi.create') }}";
                            }
                        });
                    } else {
                        Swal.fire('Error', data.message || 'Terjadi kesalahan saat menyimpan transaksi.',
                            'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Terjadi kesalahan saat menyimpan transaksi.', 'error');
                });
        });
    </script>
@endsection
