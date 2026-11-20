<?php
 
use Illuminate\Support\Facades\Route;
use Modules\Donasi\Http\Controllers\DonasiController;
 
 
Route::middleware('auth')->group(function () {

 
    Route::get(
        '/donasi',
      [DonasiController::class, 'index']
    )->name('donasi.index');
 
 
    Route::middleware('role:admin')->group(function () {
 
        Route::get(
            '/donasi/create',
            [DonasiController::class, 'create']
        )->name('donasi.create');
 
 
        Route::post(
            '/donasi',
            [DonasiController::class, 'store']
        )->name('donasi.store');
 
 
        Route::get(
            '/donasi/{id}/edit',
            [DonasiController::class, 'edit']
        )->name('donasi.edit');
 
 
        Route::put(
            '/donasi/{id}',
            [DonasiController::class, 'update']
        )->name('donasi.update');
 
 
        Route::delete(
            '/donasi/{id}',
            [DonasiController::class, 'destroy']
        )->name('donasi.destroy');
 
    });
 
});