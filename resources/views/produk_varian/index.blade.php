@extends('layouts.layout')
@section('title', 'Produk')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex">
                <select id="filter-produk" class="form-control mr-2">
                    <option value="" {{ empty($idProduk) ? 'selected' : '' }}>Semua Produk</option>
                    @foreach ($produkList as $produk)
                        <option value="{{ $produk->id }}" {{ $idProduk == $produk->id ? 'selected' : '' }}>
                            {{ $produk->nama }}
                        </option>
                    @endforeach
                </select>
                <button id="reset-filter" class="btn btn-secondary">Reset</button>
            </div>
            <div class="d-flex">
                <a href="{{ route('penerimaan_barang.create') }}" class="btn btn-primary rounded mr-2">
                    <i class="fas fa-plus"></i> Tambah Stok
                </a>
                <div class="dropdown">
                    <button class="btn btn-success rounded dropdown-toggle" type="button" id="exportDropdown"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-download"></i> Export
                    </button>
                    <div class="dropdown-menu" aria-labelledby="exportDropdown">
                        <a class="dropdown-item" href="#" id="exportExcel"><i class="fas fa-file-excel"></i> Export
                            Excel</a>
                            <a class="dropdown-item" href="{{ route('produk_varian.exportPDF', ['id_produk' => request('id_produk')]) }}" id="exportPDF">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Varian Produk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="varianTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Produk</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Total Terjual</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($produkVarians as $index => $varian)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $varian->produk->nama }}</td>
                                    <td class="text-center">{{ $varian->size }}</td>
                                    <td class="text-center">{{ $varian->warna }}</td>
                                    <td class="text-center">{{ number_format($varian->harga_jual) }}</td>
                                    <td class="text-center">{{ $varian->stok }}</td>
                                    <td class="text-center">{{ $varian->detailTransaksi->sum('total_terjual') ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let filterDropdown = document.getElementById('filter-produk');
            let resetButton = document.getElementById('reset-filter');

            // Event listener untuk dropdown filter
            filterDropdown.addEventListener('change', function() {
                let selectedId = this.value;
                let url = new URL(window.location.href);

                if (selectedId) {
                    url.searchParams.set('id_produk', selectedId);
                } else {
                    url.searchParams.delete('id_produk');
                }

                window.location.href = url.toString();
            });

            // Event listener untuk tombol reset
            resetButton.addEventListener('click', function() {
                let url = new URL(window.location.href);
                url.searchParams.delete('id_produk'); // Hapus filter dari URL
                window.location.href = url.pathname; // Redirect ke halaman tanpa parameter filter
            });
        });

        $(document).ready(function() {
            var selectedProduct = $('#filter-produk option:selected').text(); // Ambil teks produk yang dipilih
            var title = 'Laporan Varian Produk' + (selectedProduct !== 'Semua Produk' ? ' - ' + selectedProduct :
                '');

            var table = $('#varianTable').DataTable({
                dom: "<'row'<'col-md-6'l><'col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-md-6'i><'col-md-6'p>>",
                buttons: [{
                        extend: 'excelHtml5',
                        className: 'btn btn-success',
                        title: title // Gunakan title dinamis
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger',
                        title: title // Gunakan title dinamis
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary',
                        title: title // Gunakan title dinamis
                    }
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                pagingType: "simple_numbers",
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/Indonesian.json"
                }
            });

            // Fungsi Export saat dropdown diklik
            $('#exportExcel').click(function() {
                table.button(0).trigger();
            });

            $('#exportPDF').click(function() {
                table.button(1).trigger();
            });

            $('#exportPrint').click(function() {
                table.button(2).trigger();
            });
        });
    </script>
@endpush
