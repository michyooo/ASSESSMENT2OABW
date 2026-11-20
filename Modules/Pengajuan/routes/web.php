<?php

use Illuminate\Support\Facades\Route;
use Modules\Pengajuan\Http\Controllers\PengajuanController;

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DAFTAR PENGAJUAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/pengajuan',
        [PengajuanController::class, 'index']
    )->name('pengajuan.index');


    /*
    |--------------------------------------------------------------------------
    | PEMOHON - BUAT PENGAJUAN
    |--------------------------------------------------------------------------
    |
    | PENTING:
    | /create harus berada SEBELUM /{id}
    |
    */

    Route::middleware('role:pemohon')->group(function () {

        Route::get(
            '/pengajuan/create',
            [PengajuanController::class, 'create']
        )->name('pengajuan.create');


        Route::post(
            '/pengajuan',
            [PengajuanController::class, 'store']
        )->name('pengajuan.store');


        Route::get(
            '/pengajuan/{id}/edit',
            [PengajuanController::class, 'edit']
        )
        ->whereNumber('id')
        ->name('pengajuan.edit');


        Route::put(
            '/pengajuan/{id}',
            [PengajuanController::class, 'update']
        )
        ->whereNumber('id')
        ->name('pengajuan.update');

    });


    /*
    |--------------------------------------------------------------------------
    | ADMIN - KEPUTUSAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::patch(
            '/pengajuan/{id}/approve',
            [PengajuanController::class, 'approve']
        )
        ->whereNumber('id')
        ->name('pengajuan.approve');


        Route::patch(
            '/pengajuan/{id}/reject',
            [PengajuanController::class, 'reject']
        )
        ->whereNumber('id')
        ->name('pengajuan.reject');

    });


    /*
    |--------------------------------------------------------------------------
    | HAPUS
    |--------------------------------------------------------------------------
    |
    | Admin:
    | semua transaksi
    |
    | Pemohon:
    | milik sendiri + Menunggu
    |
    | Pengecekan detail dilakukan di controller
    |
    */

    Route::delete(
        '/pengajuan/{id}',
        [PengajuanController::class, 'destroy']
    )
    ->whereNumber('id')
    ->name('pengajuan.destroy');


    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    |
    | HARUS PALING BAWAH.
    |
    | whereNumber() membuat {id} hanya menerima angka.
    | Jadi "create" tidak mungkin dianggap ID.
    |
    */

    Route::get(
        '/pengajuan/{id}',
        [PengajuanController::class, 'show']
    )
    ->whereNumber('id')
    ->name('pengajuan.show');

});