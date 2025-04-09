<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //Route User
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::get('/nonaktifkan-akun/{userId}', [UserController::class, 'nonaktifkanAkun'])->name('user.nonaktifkan');
    Route::get('/aktifkan-akun/{userId}', [UserController::class, 'aktifkanAkun'])->name('user.aktifkan');

    // Route Member
    Route::get('member', [MemberController::class, 'index'])->name('member.index');
    Route::get('member/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('member', [MemberController::class, 'store'])->name('member.store');
    Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::get('/nonaktifkan-member/{memberId}', [MemberController::class, 'nonaktifkanAkun'])->name('member.nonaktifkan');
    Route::get('/aktifkan-member/{memberId}', [MemberController::class, 'aktifkanAkun'])->name('member.aktifkan');


    // Route Kategori
    Route::get('kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::post('kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');

    // Route Supplier
    Route::get('supplier', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('supplier/store', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('supplier/{id}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/supplier/{id}', [SupplierController::class, 'update'])->name('supplier.update');

});

// Route untuk Login
Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
