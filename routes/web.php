<?php

use App\Http\Controllers\AbsensiKerjaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PenerimaanBarangController;
use App\Http\Controllers\PengajuanBarangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukVarianController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekUserRole;
use Illuminate\Support\Facades\Route;


// Redirect user yang mengunjungi root ('/') langsung ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Menampilkan halaman login untuk route '/login' dengan method GET
// Halaman ini akan berisi form login (email, password) untuk pengguna yang belum login
Route::view('/login', 'auth.login')->name('login');

// Proses login menggunakan POST request ke '/login'
// Saat form login dikirim (POST), method 'login' pada 'LoginController' akan dipanggil
Route::post('/login', [LoginController::class, 'login']);

// Proses logout menggunakan POST request ke '/logout'
// Saat logout diproses, 'logout' method pada 'LoginController' akan dijalankan
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route yang butuh autentikasi + cek role
Route::middleware(['auth', CekUserRole::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/transaksi-harian', [DashboardController::class, 'getTransaksiHarian']);

    // User
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::get('/nonaktifkan-akun/{userId}', [UserController::class, 'nonaktifkanAkun'])->name('user.nonaktifkan');
    Route::get('/aktifkan-akun/{userId}', [UserController::class, 'aktifkanAkun'])->name('user.aktifkan');

    // Member
    Route::get('member', [MemberController::class, 'index'])->name('member.index');
    Route::get('member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('member', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::get('/nonaktifkan-member/{memberId}', [MemberController::class, 'nonaktifkanAkun'])->name('member.nonaktifkan');
    Route::get('/aktifkan-member/{memberId}', [MemberController::class, 'aktifkanAkun'])->name('member.aktifkan');
    Route::post('member/import', [MemberController::class, 'import'])->name('member.import');

    // Kategori
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::post('/kategori/import', [KategoriController::class, 'import'])->name('kategori.import');
    Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');

    // Supplier
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::post('/supplier/import', [SupplierController::class, 'import'])->name('supplier.import');

    // Produk
    Route::get('produk', [ProdukController::class, 'index'])->name('produk.index');
    Route::get('produk/create', [ProdukController::class, 'create'])->name('produk.create');
    Route::post('produk/store', [ProdukController::class, 'store'])->name('produk.store');
    Route::get('produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::get('/produk/{id}/details', [ProdukController::class, 'details'])->name('produk.details');

    // Produk Varian
    Route::get('produk_varian', [ProdukVarianController::class, 'index'])->name('produk_varian.index');
    Route::get('produk_varian/create', [ProdukVarianController::class, 'create'])->name('produk_varian.create');
    Route::post('produk_varian/store', [ProdukVarianController::class, 'store'])->name('produk_varian.store');
    Route::get('/export_produk-pdf', [ProdukVarianController::class, 'exportPDF'])->name('export_produk.pdf');
    Route::get('/produk-varian/export-pdf', [ProdukVarianController::class, 'exportPDF'])->name('produk_varian.exportPDF');
    Route::get('/export-products', [ProdukVarianController::class, 'export'])->name('products.export');


    // Penerimaan Barang
    Route::get('penerimaan_barang', [PenerimaanBarangController::class, 'index'])->name('penerimaan_barang.index');
    Route::get('penerimaan_barang/create', [PenerimaanBarangController::class, 'create'])->name('penerimaan_barang.create');
    Route::get('/penerimaan-barang/get-produk/{supplierId}', [PenerimaanBarangController::class, 'getProdukBySupplier']);
    Route::get('/penerimaan-barang/get-varian/{produkId}', [PenerimaanBarangController::class, 'getVarianByProduk']);
    Route::post('/penerimaan-barang/store', [PenerimaanBarangController::class, 'store'])->name('penerimaan_barang.store');
    Route::get('/penerimaan-barang/{id}/details', [PenerimaanBarangController::class, 'details'])->name('penerimaan_barang.details');

    // Transaksi
    Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('transaksi/store', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/get-varians/{produkId}', [TransaksiController::class, 'getVariansByProduk']);
    Route::get('/get-sizes/{produkId}/{warna}', [TransaksiController::class, 'getSizesByWarna']);
    Route::get('/get-harga/{produkId}/{warna}/{size}', [TransaksiController::class, 'getHarga']);
    Route::get('/get-varian/{produk_id}/{warna}/{size}', [TransaksiController::class, 'getVarian']);
    Route::get('/transaksi/{id}/details', [TransaksiController::class, 'details'])->name('transaksi.details');
    Route::get('/export-pdf', [TransaksiController::class, 'exportPDF'])->name('export.pdf');
    Route::get('/transaksi/export-pdf', [TransaksiController::class, 'exportPDF'])->name('transaksi.exportPDF');
    Route::get('/export-transactions', [TransaksiController::class, 'export'])->name('transactions.export');
    Route::get('/struk/{id}', [TransaksiController::class, 'struk'])->name('transaksi.struk');

    // Pengajuan Barang
    Route::get('index', [PengajuanBarangController::class, 'index'])->name('pengajuanBarang.index');
    Route::post('pengajuan/store', [PengajuanBarangController::class, 'store'])->name('pengajuanBarang.store');
    Route::put('pengajuan/{id}', [PengajuanBarangController::class, 'update'])->name('pengajuanBarang.update');
    Route::delete('/pengajuan-barang/{id}', [PengajuanBarangController::class, 'destroy'])->name('pengajuanBarang.destroy');
    Route::get('/data-pengajuan', [PengajuanBarangController::class, 'getDataPengajuan']);
    Route::post('/pengajuan/{id}/update-terpenuhi', [PengajuanBarangController::class, 'updateTerpenuhi'])->name('pengajuan.updateTerpenuhi');
    Route::get('/pengajuan/export-pdf', [PengajuanBarangController::class, 'exportPDF'])->name('pengajuanBarang.exportPDF');

    // Absensi Kerja
    Route::get('/absen-kerja', [AbsensiKerjaController::class, 'index'])->name('absen.index');
    Route::post('/absen-kerja/create', [AbsensiKerjaController::class, 'store'])->name('absen.store');
    Route::put('/absen-kerja/{id}/update', [AbsensiKerjaController::class, 'update'])->name('absen.update');
    Route::delete('/absen-kerja/{id}', [AbsensiKerjaController::class, 'destroy'])->name('absen.destroy');
    Route::put('/absensi/{id}/update-waktu-selesai', [AbsensiKerjaController::class, 'updateWaktuSelesai']);

});
