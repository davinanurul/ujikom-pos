@extends('layouts.layout')
@section('title', 'Kategori Produk')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><i class="fa fa-tags text-primary mr-2"></i> Kategori Produk</h4>
            <div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addKategoriModal">
                    <i class="fa fa-plus mr-1"></i> Tambah
                </button>
                <button class="btn btn-warning text-white" onclick="window.print();">
                    <i class="fa fa-print text-white mr-1"></i> Print/Ekspor
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div>
                        <div class="table-responsive mb-5">
                            <table class="table table-striped table-bordered zero-configuration">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 8%">No</th>
                                        <th class="text-center">Nama Kategori</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategoris as $index => $kategori)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $kategori->nama_kategori }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-success btn edit-btn text-white"
                                                    data-id="{{ $kategori->id }}" data-nama="{{ $kategori->nama_kategori }}"
                                                    data-toggle="modal" data-target="#editKategoriModal">
                                                    <i class="fa fa-edit text-white"></i> Edit
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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

    <!-- Modal Edit Kategori -->
    {{-- <div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                </div>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_id" name="id" value="{{ $kategori->id }}">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori"
                                value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn mb-1 btn-outline-primary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn mb-1 btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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

        $(document).on('click', '.edit-btn', function() {
            var kategoriId = $(this).data('id'); // Ambil ID kategori dari tombol

            // Mengambil data kategori melalui Ajax
            $.ajax({
                url: '/kategori/' + kategoriId + '/edit', // Sesuaikan dengan route yang sesuai
                type: 'GET',
                success: function(data) {
                    // Isi form modal dengan data yang diterima
                    $('#editForm').attr('action', '/kategori/' + data.kategori.id);
                    $('#kategori_name').val(data.kategori.name);
                    // Lanjutkan untuk mengisi input lainnya jika ada
                    $('#editModal').modal('show'); // Tampilkan modal
                },
                error: function() {
                    alert('Error retrieving data.');
                }
            });
        });
    </script>
@endsection
