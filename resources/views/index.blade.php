<?php
 
use Illuminate\Support\Facades\Route;
use Modules\Pengajuan\Http\Controllers\PengajuanController;
 
Route::get('/pengajuan', [PengajuanController::class, 'index'])
    ->name('pengajuan.index');

    